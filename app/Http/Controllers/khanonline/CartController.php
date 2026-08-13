<?php

namespace App\Http\Controllers\khanonline;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly CheckoutService $checkoutService
    ) {}

    public function page(): View
    {
        return view('2khanonline.cart.index');
    }

    public function checkout(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'address' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'address.required' => 'لطفاً آدرس تحویل را وارد کنید.',
            'address.min' => 'آدرس تحویل باید حداقل ۱۰ کاراکتر باشد.',
            'address.max' => 'آدرس تحویل بیش از حد طولانی است.',
        ]);

        try {
            $order = $this->checkoutService->start(
                $request->user(),
                trim($validated['address'])
            );

            return redirect()->route('payment.show', $order);
        } catch (ValidationException $exception) {
            return redirect()
                ->route('cart.index')
                ->with('payment_error', collect($exception->errors())->flatten()->first());
        }
    }

    public function index(): JsonResponse
    {
        return response()->json($this->cartPayload($this->cartService->getCart()));
    }

    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->stock < 1) {
            return response()->json([
                'message' => 'این محصول موجود نیست',
            ], 422);
        }

        try {
            $item = $this->cartService->addItem($product, $validated['quantity']);

            return response()->json([
                'message' => 'محصول به سبد خرید اضافه شد',
                'item' => $this->cartItemPayload($item),
                'cart' => $this->cartPayload($this->cartService->getCart()),
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function update(Request $request, CartItem $item): JsonResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $item = $this->cartService->updateQuantity($item, $validated['quantity']);

            return response()->json([
                'message' => 'تعداد محصول بروزرسانی شد',
                'item' => $this->cartItemPayload($item),
                'cart' => $this->cartPayload($this->cartService->getCart()),
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function remove(CartItem $item): JsonResponse
    {
        $this->cartService->removeItem($item);

        return response()->json([
            'message' => 'محصول از سبد خرید حذف شد',
            'cart' => $this->cartPayload($this->cartService->getCart()),
        ]);
    }

    public function clear(): JsonResponse
    {
        $this->cartService->clear();

        return response()->json([
            'message' => 'سبد خرید خالی شد',
            'cart' => $this->cartPayload($this->cartService->getCart()),
        ]);
    }

    private function cartPayload(Cart $cart): array
    {
        $cart->loadMissing('items.product.category', 'items.product.brand');

        return [
            'items' => $cart->items->map(fn (CartItem $item) => $this->cartItemPayload($item))->values(),
            'total' => $cart->total(),
            'total_items' => $cart->totalItems(),
        ];
    }

    private function cartItemPayload(CartItem $item): array
    {
        $item->loadMissing('product.category', 'product.brand');

        return [
            'id' => $item->id,
            'product_id' => $item->product_id,
            'name' => $item->product->name,
            'slug' => $item->product->slug,
            'url' => route('products.show', $item->product->slug),
            'image' => $item->product->image_url,
            'category' => $item->product->category?->name,
            'brand' => $item->product->brand?->name,
            'stock' => $item->product->stock,
            'price' => $item->price,
            'quantity' => $item->quantity,
            'subtotal' => $item->subtotal(),
        ];
    }
}
