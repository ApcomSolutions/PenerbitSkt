<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        // Fetch active categories for the filter dropdown
        $categories = ProductCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.index', compact('categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = ProductCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Show the form for editing a product.
     */
    public function edit($id)
    {
        $categories = ProductCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.edit', [
            'productId' => $id,
            'categories' => $categories
        ]);
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        return view('admin.products.show', ['productId' => $id]);
    }

    /**
     * Display a listing of the trashed products.
     */
    public function trash(Request $request)
    {
        return view('admin.products.trash');
    }
}
