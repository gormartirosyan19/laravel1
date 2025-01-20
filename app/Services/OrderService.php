<?php

namespace App\Services;

use App\Models\{Order, OrderItem, Cart, Activity};
use Illuminate\Support\Facades\{Auth, DB};
use Carbon\Carbon;

class OrderService
{
    public function getUserOrders()
    {
        return Order::with('items.product.images')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
    }

    public function createOrder($shippingAddressId)
    {
        return DB::transaction(function () use ($shippingAddressId) {
            $cartItems = Cart::where('user_id', Auth::id())->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('status', 'Your cart is empty');
            }

            foreach ($cartItems as $item) {
                if ($item->product->stock < $item->quantity) {
                    return redirect()->back()->with('status', "Insufficient stock for product: {$item->product->title}");
                }
            }

            $totalAmount = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            $order = Order::create([
                'user_id' => Auth::id(),
                'shipping_address_id' => $shippingAddressId,
                'status' => 'pending',
                'total_amount' => $totalAmount,
            ]);

            $orderItemsData = $cartItems->map(function ($item) use ($order) {
                return [
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'total' => $item->product->price * $item->quantity,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            })->toArray();

            OrderItem::insert($orderItemsData);

            $activityDetails = $this->generateActivityDetails($cartItems);

            Activity::create([
                'user_id' => Auth::id(),
                'activity_type' => 'product_ordered',
                'activity_details' => $activityDetails,
            ]);

            Cart::where('user_id', Auth::id())->delete();

            return $order;
        });
    }

    private function generateActivityDetails($cartItems)
    {
        $details = 'ordered the following products: ';
        foreach ($cartItems as $item) {
            $details .= $item->product->title . ' (x' . $item->quantity . ') for $' . number_format($item->product->price * $item->quantity, 2) . ', ';
        }
        return rtrim($details, ', ');
    }
}
