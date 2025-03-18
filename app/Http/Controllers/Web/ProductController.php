<?php
//public
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\ProductService;
use App\Services\ProductCategoryService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;

    public function __construct(ProductService $productService, ProductCategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of products
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            // Get all categories for filter dropdown
            $categories = $this->categoryService->getAllActive();

            // Apply filters
            $categoryId = $request->input('category');
            $search = $request->input('search');
            $sort = $request->input('sort', 'latest');

            // Get products with pagination based on filters
            $productsQuery = Product::with(['categories', 'images' => function($query) {
                // Fix the subquery issue by removing the problematic orWhereRaw
                $query->where('is_primary', true)
                    ->orWhereRaw('id = (SELECT MIN(id) FROM product_images WHERE product_id = product_images.product_id)');
                // Alternatively, you could just use this simplified approach:
                // $query->orderBy('is_primary', 'desc')->orderBy('id', 'asc')->limit(1);
            }])
                ->where('is_published', true);

            // Apply category filter
            if ($categoryId) {
                $productsQuery->whereHas('categories', function($query) use ($categoryId) {
                    $query->where('product_categories.id', $categoryId);
                });
            }

            // Apply search filter
            if ($search) {
                $productsQuery->where(function($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('publisher', 'like', "%{$search}%");
                });
            }

            // Apply sorting
            switch ($sort) {
                case 'oldest':
                    $productsQuery->oldest();
                    break;
                case 'price_low':
                    $productsQuery->orderBy('discount_price', 'asc')
                        ->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $productsQuery->orderBy('discount_price', 'desc')
                        ->orderBy('price', 'desc');
                    break;
                case 'latest':
                default:
                    $productsQuery->latest();
                    break;
            }

            // Get paginated results
            $products = $productsQuery->paginate(12)->withQueryString();

            // Return view with data
            return view('products.index', compact('products', 'categories'));
        } catch (\Exception $e) {
            \Log::error('Error in products index', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Return view with error
            return view('products.index', [
                'products' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 12),
                'categories' => collect([]),
                'error' => 'Terjadi kesalahan saat memuat produk.'
            ]);
        }
    }

    /**
     * Generate WhatsApp link for product ordering
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateWhatsAppLink(Request $request)
    {
        try {
            // Validate request
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'name' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:255',
                'address' => 'nullable|string',
                'notes' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get product details
            $product = Product::findOrFail($request->input('product_id'));
            $quantity = $request->input('quantity', 1);

            // Get customer info
            $customerInfo = [
                'name' => $request->input('name', ''),
                'phone' => $request->input('phone', ''),
                'address' => $request->input('address', ''),
                'notes' => $request->input('notes', '')
            ];

            // Set your WhatsApp number
            $whatsappNumber = "628125881289"; // CHANGE THIS to your business WhatsApp number


            // Calculate price
            $price = $product->discount_price ?: $product->price;
            $totalPrice = $price * $quantity;

            // Create message
            $message = "Halo, saya ingin memesan produk berikut:\n\n";
            $message .= "*Produk:* " . $product->title . "\n";
            $message .= "*Harga:* Rp " . number_format($price, 0, ',', '.') . "\n";
            $message .= "*Jumlah:* " . $quantity . "\n";
            $message .= "*Total:* Rp " . number_format($totalPrice, 0, ',', '.') . "\n\n";

            // Add customer info if provided
            if (!empty($customerInfo['name'])) {
                $message .= "*Informasi Pemesan:*\n";
                $message .= "Nama: " . $customerInfo['name'] . "\n";

                if (!empty($customerInfo['phone'])) {
                    $message .= "Telepon: " . $customerInfo['phone'] . "\n";
                }

                if (!empty($customerInfo['address'])) {
                    $message .= "Alamat: " . $customerInfo['address'] . "\n";
                }

                if (!empty($customerInfo['notes'])) {
                    $message .= "\nCatatan: " . $customerInfo['notes'] . "\n";
                }
            }

            $message .= "\nTerima kasih.";

            // Create WhatsApp URL
            $whatsappUrl = "https://wa.me/" . $whatsappNumber . "?text=" . urlencode($message);

            return response()->json([
                'success' => true,
                'whatsapp_link' => $whatsappUrl,
                'message' => 'WhatsApp link generated successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error generating WhatsApp link', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified product
     *
     * @param string $slug
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($slug)
    {
        // Find the product by slug
        $product = $this->productService->findBySlug($slug);

        // If product not found or not published, redirect to products page
        if (!$product || !$product->is_published) {
            return redirect()->route('products.index')
                ->with('error', 'Produk tidak ditemukan.');
        }

        // Get related products (from same categories)
        $relatedProducts = Product::with(['categories', 'images' => function($query) {
            $query->where('is_primary', true);
        }])
            ->where('is_published', true)
            ->where('id', '!=', $product->id)
            ->whereHas('categories', function($query) use ($product) {
                $query->whereIn('product_categories.id', $product->categories->pluck('id'));
            })
            ->latest()
            ->limit(4)
            ->get();

        // Return view with data
        return view('products.show', compact('product', 'relatedProducts'));
    }
}
