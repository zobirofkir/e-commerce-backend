<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(
            Product::orderBy('id', 'desc')->get()
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return ProductResource::make($product);
    }

    /**
     * Create Search Method
     */
    public function search($title = null)
    {
        if (!$title) {
            return response()->json([], 400);
        }
    
        $products = Product::where('title', 'LIKE', "%{$title}%")
            ->orWhere('description', 'LIKE', "%{$title}%")
            ->orderBy('id', 'desc')
            ->get();
    
        return ProductResource::collection($products);
    }
}
