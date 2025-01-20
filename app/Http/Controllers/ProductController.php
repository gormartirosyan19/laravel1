<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $userId = $request->user_id;

        $query = Product::query();
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $products = $this->productService->getAllProducts($userId);

        return view('products.index', compact('products'));
    }


    public function create()
    {
        return view('products.create');
    }

    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        try {
            $this->productService->createProduct($validated);

            return redirect()->route('products.index')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong! Please try again later.');
        }
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        if ($product->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        return view('products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        try {
            $this->productService->updateProduct($product, $validated);

            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong! Please try again later.');
        }
    }

    public function destroy(Product $product)
    {
        try {
            $this->productService->destroyProduct($product);

            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong! Please try again later.');
        }
    }

}
