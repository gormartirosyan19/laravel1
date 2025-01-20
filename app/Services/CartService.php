<?php
namespace App\Services;

use App\Models\Cart;
use App\Models\Product;

class CartService
{
    public function getUserCartItems()
    {
        return Cart::with('product.images')->where('user_id', auth()->id())->get();
    }

    public function addOrUpdateCartItem(array $data)
    {
        $product = Product::find($data['product_id']);

        if ($product->stock < $data['quantity']) {
            return ['success' => false, 'message' => 'Not enough stock available.'];
        }

        $size = $data['size'] ?? null;
        $color = $data['color'] ?? null;

        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $data['product_id'])
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $data['quantity'];
            $cartItem->size = $size;
            $cartItem->color = $color;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
                'size' => $size,
                'color' => $color,
            ]);
        }

        return ['success' => true, 'message' => 'Product added to your cart.'];
    }

    public function updateCartItemQuantity($productId, $quantity)
    {
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if (!$cartItem) {
            return ['success' => false, 'message' => 'Product not found in your cart.'];
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        return ['success' => true, 'message' => 'Cart updated successfully.'];
    }

    public function removeCartItem($productId)
    {
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if (!$cartItem) {
            return ['success' => false, 'message' => 'Product not found in your cart.'];
        }

        $cartItem->delete();

        return ['success' => true, 'message' => 'Product removed from cart.'];
    }

    public function prepareCheckout()
    {
        $user = auth()->user();

        if (!$user) {
            return [
                'success' => false,
                'redirect' => route('auth.login'),
                'message' => 'Please log in to continue.',
            ];
        }

        $user->load('defaultAddress');

        if (!$user->defaultAddress) {
            return [
                'success' => false,
                'redirect' => route('address.index'),
                'message' => 'Please set a default address in your profile.',
            ];
        }

        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return [
                    'success' => false,
                    'redirect' => route('cart.index'),
                    'message' => 'Not enough stock available for ' . $item->product->title,
                ];
            }
        }

        $totalAmount = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return [
            'success' => true,
            'user' => $user,
            'cartItems' => $cartItems,
            'totalAmount' => $totalAmount,
        ];
    }

}
