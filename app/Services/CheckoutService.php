<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Exceptions\PurchaseFailedException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class CheckoutService
{
    public function __construct(
        private readonly CartService $cartService
    ) {}

    public function start(User $user, string $address): Order
    {
        $cart = $this->cartService->getCart();
        $cart->loadMissing('items.product');

        if ($cart->items->isEmpty()) {
            throw ValidationException::withMessages([
                'cart' => 'سبد خرید شما خالی است.',
            ]);
        }

        $this->assertCartIsPurchasable($cart);

        $order = $this->createPendingOrder($user, $cart, $address);

        return $order;
    }

    public function verify(string $transactionId): Order
    {
        $order = Order::query()
            ->with('items')
            ->where('transaction_id', $transactionId)
            ->firstOrFail();

        if ($order->isPaid()) {
            return $order;
        }

        try {
            $receipt = Payment::via('zibal')
                ->amount($order->amount)
                ->transactionId($transactionId)
                ->verify();

            DB::transaction(function () use ($order, $receipt): void {
                $order->update([
                    'status' => Order::STATUS_PAID,
                    'reference_id' => (string) $receipt->getReferenceId(),
                    'paid_at' => now(),
                ]);

                foreach ($order->items as $item) {
                    if (! $item->product_id) {
                        continue;
                    }

                    Product::query()
                        ->whereKey($item->product_id)
                        ->where('stock', '>=', $item->quantity)
                        ->decrement('stock', $item->quantity);
                }

                if (auth()->check() && (int) auth()->id() === (int) $order->user_id) {
                    $this->cartService->clear();
                } else {
                    $this->clearUserCart($order->user_id);
                }
            });
        } catch (InvalidPaymentException|PurchaseFailedException $exception) {
            $order->update(['status' => Order::STATUS_FAILED]);

            throw $exception;
        }

        return $order->fresh('items');
    }

    private function assertCartIsPurchasable(Cart $cart): void
    {
        foreach ($cart->items as $item) {
            $product = $item->product;

            if (! $product) {
                throw ValidationException::withMessages([
                    'cart' => 'یکی از محصولات سبد خرید دیگر موجود نیست.',
                ]);
            }

            if ($product->stock < $item->quantity) {
                throw ValidationException::withMessages([
                    'cart' => "موجودی «{$product->name}» کافی نیست.",
                ]);
            }
        }
    }

    private function createPendingOrder(User $user, Cart $cart, string $address): Order
    {
        return DB::transaction(function () use ($user, $cart, $address): Order {
            $user->update(['address' => $address]);

            $order = Order::query()->create([
                'user_id' => $user->id,
                'amount' => $cart->total(),
                'address' => $address,
                'status' => Order::STATUS_PENDING,
                'payment_status' => Order::PAYMENT_PENDING,
                'gateway' => 'card_to_card',
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                ]);
            }

            return $order->load('items');
        });
    }

    private function clearUserCart(int $userId): void
    {
        $cart = Cart::query()->where('user_id', $userId)->first();

        if ($cart) {
            $cart->items()->delete();
        }
    }
}
