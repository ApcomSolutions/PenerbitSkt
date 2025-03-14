<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class HomeController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index() {
        // SEO untuk halaman beranda
        $seoData = new SEOData(
            title: 'ApCom Solutions - Membangun Reputasi Menciptakan Solusi',
            description: 'ApCom Solutions adalah konsultan komunikasi dan PR yang membantu Anda membangun reputasi yang kuat.',
            url: route('home')
        );

        // Get featured products for the homepage
        $featuredProducts = $this->productService->getFeatured(8);

        return view('index', [
            'seoData' => $seoData,
            'featuredProducts' => $featuredProducts
        ]);
    }
}
