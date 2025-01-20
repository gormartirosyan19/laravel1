<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {// Fetching posts
        $posts = Post::latest()->get();

        // Fetching products with images
        $products = Product::latest()->with('images')->get();

        // Passing both posts and products to the view
        return view('welcome', compact('posts', 'products'));
    }

}
