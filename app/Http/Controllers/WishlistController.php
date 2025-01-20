<?php
namespace App\Http\Controllers;

use App\Services\WishlistService;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    protected $wishlistService;

    public function __construct(WishlistService $wishlistService)
    {
        $this->wishlistService = $wishlistService;
    }

    public function index()
    {
        $wishlistItems = $this->wishlistService->getUserWishlistItems();
        return view('wishlist.index', compact('wishlistItems'));
    }

    public function toggle(Request $request)
    {
        try {
            $productId = $request->product_id;
            $result = $this->wishlistService->toggleWishlistItem($productId);

            session()->flash('success', $result['message']);

            return response()->json([
                'status' => $result['status'],
                'message' => $result['message'],
                'redirect_url' => route('wishlist.index'),
                'reload' => true
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    public function destroy($productId)
    {
        $result = $this->wishlistService->removeWishlistItem($productId);

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->back()->with('success', $result['message']);
    }
}
