<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index(Request $request)
    {
        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Show the form for editing a category.
     */
    public function edit($id)
    {
        return view('admin.categories.edit', ['categoryId' => $id]);
    }

    /**
     * Display the specified category.
     */
    public function show($id)
    {
        return view('admin.categories.create', ['categoryId' => $id]);
    }
}
