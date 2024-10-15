<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CategoryResource::collection(
            Category::orderBy('id', 'desc')->get()

        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return CategoryResource::make($category);
    }

        /**
     * Get the products for the specified category.
     */
    public function getProducts(Category $category)
    {
        $products = $category->products()->orderBy('id', 'desc')->paginate(10);
        return ProductResource::collection($products);
    }
}
