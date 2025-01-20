<?php
namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartItems = $this->cartService->getUserCartItems();

        return view('cart.index', compact('cartItems'));
    }

    public function store(CartRequest $request)
    {
        $response = $this->cartService->addOrUpdateCartItem($request->validated());

        return redirect()->route('cart.index')->with('status', $response['message']);
    }

    public function update(Request $request, $productId)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $response = $this->cartService->updateCartItemQuantity($productId, $request->quantity);

        return redirect()->route('cart.index')->with($response['success'] ? 'success' : 'error', $response['message']);
    }

    public function destroy($productId)
    {
        $response = $this->cartService->removeCartItem($productId);

        return redirect()->route('cart.index')->with($response['success'] ? 'success' : 'error', $response['message']);
    }

    public function checkout()
    {
        $response = $this->cartService->prepareCheckout();
        if (!$response['success']) {
            return redirect($response['redirect'])->with('status', $response['message']);
        }

        return view('cart.checkout', [
            'user' => $response['user'],
            'cartItems' => $response['cartItems'],
            'totalAmount' => $response['totalAmount'],
        ]);
    }
}
