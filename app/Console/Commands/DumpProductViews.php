<?php

namespace App\Console\Commands;

use App\Models\ProductCategory;
use Illuminate\Console\Command;

class DumpProductViews extends Command
{
    protected $signature = 'products:dump-views';
    protected $description = 'Dump all product views for debugging';

    public function handle()
    {
        $categories = ProductCategory::where('is_active', true)->orderBy('name')->get();

        $views = [
            'index' => view('admin.products.index', ['categories' => $categories]),
            'create' => view('admin.products.create', ['categories' => $categories]),
            'edit' => view('admin.products.edit', ['productId' => 1, 'categories' => $categories]),
            'show' => view('admin.products.show', ['productId' => 1]),
            'trash' => view('admin.products.trash')
        ];

        dd($views);
    }
}
