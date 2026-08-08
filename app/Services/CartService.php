<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart(): Cart
    {
        $cart = $this->findCart();

        if (! $cart) {
            $cart = Cart::create($this->cartIdentifiers());
            Session::put('cart_id', $cart->id);
        }

        return $cart;
    }

    public function addItem(Product $product, int $quantity = 1): CartItem
    {
        $cart = $this->getCart();

        $existingItem = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $quantity;

            if ($newQuantity > $product->stock) {
                throw new \InvalidArgumentException(
                    "موجودی کافی نیست. حداکثر موجودی: {$product->stock}"
                );
            }

            $existingItem->update([
                'quantity' => $newQuantity,
                'price' => $product->price,
            ]);

            return $existingItem;
        }

        if ($quantity > $product->stock) {
            throw new \InvalidArgumentException(
                "موجودی کافی نیست. حداکثر موجودی: {$product->stock}"
            );
        }

        return $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $product->price,
        ]);
    }

    public function updateQuantity(CartItem $item, int $quantity): CartItem
    {
        if ($quantity > $item->product->stock) {
            throw new \InvalidArgumentException(
                "موجودی کافی نیست. حداکثر موجودی: {$item->product->stock}"
            );
        }

        $item->update(['quantity' => $quantity]);

        return $item;
    }

    public function removeItem(CartItem $item): void
    {
        $item->delete();
    }

    public function clear(): void
    {
        $cart = $this->findCart();

        if ($cart) {
            $cart->items()->delete();
        }
    }

    private function findCart(): ?Cart
    {
        $query = Cart::with('items.product');

        if (auth()->check()) {
            return $query->where('user_id', auth()->id())->first();
        }

        $sessionId = Session::get('cart_id');

        if ($sessionId) {
            return $query->where('id', $sessionId)->whereNull('user_id')->first();
        }

        return null;
    }

    private function cartIdentifiers(): array
    {
        if (auth()->check()) {
            return ['user_id' => auth()->id()];
        }

        return ['session_id' => Session::getId()];
    }
}
