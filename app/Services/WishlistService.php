<?php

namespace App\Services;

use App\Models\Wishlist;
use Illuminate\Support\Facades\{Auth, DB};

class WishlistService
{
    public function getUserWishlistItems()
    {
        return Wishlist::with('product.images')
            ->where('user_id', Auth::id())
            ->get();
    }

    public function toggleWishlistItem($productId)
    {
        return DB::transaction(function () use ($productId) {
            $userId = Auth::id();

            $wishlist = Wishlist::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();

            if ($wishlist) {
                $wishlist->delete();
                return ['status' => 'removed', 'message' => 'Product removed from your wishlist!'];
            } else {
                Wishlist::create(['user_id' => $userId, 'product_id' => $productId]);
                return ['status' => 'added', 'message' => 'Product added to your wishlist!'];
            }
        });
    }

    public function removeWishlistItem($productId)
    {
        return DB::transaction(function () use ($productId) {
            $wishlistItem = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if (!$wishlistItem) {
                return ['success' => false, 'message' => 'Product not found in your wishlist.'];
            }

            $wishlistItem->delete();

            return ['success' => true, 'message' => 'Product removed from wishlist!'];
        });
    }
}
