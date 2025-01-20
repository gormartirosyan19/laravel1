<?php
namespace App\Services;

use App\Models\Product;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function getAllProducts($userId = null)
    {
        $query = Product::query();

//        if ($userId) {
//            $query->where('user_id', $userId);
//        }

        return $query->latest()->get();
    }

    public function createProduct(array $data)
    {
        DB::beginTransaction();

        try {
            $product = Product::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'price' => $data['price'],
                'color' => $data['color'] ?? null,
                'size' => $data['size'] ?? null,
                'stock' => $data['stock'],
                'user_id' => Auth::id(),
            ]);

            if (isset($data['images'])) {
                foreach ($data['images'] as $image) {
                    $path = $image->store('product_images', 'public');
                    $product->images()->create(['image_path' => $path]);
                }
            }

            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateProduct(Product $product, array $data)
    {
        DB::beginTransaction();

        try {
            if ($product->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
                throw new \Exception('Unauthorized');
            }

            $product->update([
                'title' => $data['title'],
                'description' => $data['description'],
                'price' => $data['price'],
                'color' => $data['color'],
                'size' => $data['size'],
                'stock' => $data['stock'],
            ]);

            if (isset($data['images'])) {
                foreach ($product->images as $image) {
                    Storage::delete('public/' . $image->image_path);
                    $image->delete();
                }

                foreach ($data['images'] as $image) {
                    $path = $image->store('product_images', 'public');
                    $product->images()->create(['image_path' => $path]);
                }
            }

            Activity::create([
                'user_id' => Auth::id(),
                'activity_type' => 'product_updated',
                'activity_details' => 'Updated the product titled: ' . $data['title'],
            ]);

            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroyProduct(Product $product)
    {
        DB::beginTransaction();

        try {
            if ($product->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
                throw new \Exception('Unauthorized');
            }

            foreach ($product->images as $image) {
                $imagePath = $image->image_path;

                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }

                $image->delete();
            }

            $product->delete();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
