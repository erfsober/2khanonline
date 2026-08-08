<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (! $user) {
            return;
        }

        $cart = Cart::create([
            'user_id' => $user->id,
        ]);

        $products = Product::inRandomOrder()->limit(3)->get();

        foreach ($products as $product) {
            $quantity = rand(1, min(3, $product->stock));

            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }
    }
}
