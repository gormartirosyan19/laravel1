<?php
namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->getUserOrders();
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address_id' => 'required|exists:addresses,id',
        ]);

        $this->orderService->createOrder($request->shipping_address_id);

        return redirect()->route('cart.ordered')->with('success', 'Your order has been placed successfully!');
    }

    public function success()
    {
        return view('cart.ordered');
    }
}
