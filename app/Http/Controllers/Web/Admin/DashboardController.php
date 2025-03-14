<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // We'll still use some direct DB queries for simple counts
        // that don't involve complex business logic
        $productCount = Product::count();
        $categoryCount = ProductCategory::count();
        $featuredCount = Product::where('is_featured', true)->count();
        $lowStockCount = Product::where('stock', '<', 5)->where('stock', '>', 0)->count();

        // For the recent products, we'll now render them client-side
        return view('admin.dashboard', compact(
            'productCount',
            'categoryCount',
            'featuredCount',
            'lowStockCount'
        ));
    }
}
