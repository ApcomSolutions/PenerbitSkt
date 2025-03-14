<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Get all products
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        // Ambil parameter trashed dan parameter filter lainnya
        $params = [
            'trashed' => $request->get('trashed'),
            'search' => $request->get('search'),
            'category' => $request->get('category'),
            'status' => $request->get('status')
        ];

        $products = $this->productService->getAll($perPage, $params);

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Get a specific product
     */
    public function show($id)
    {
        $product = $this->productService->findById($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    /**
     * Create a new product
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products',
            'description' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'publish_date' => 'nullable|date',
            'isbn' => 'nullable|string|max:255',
            'dimensions' => 'nullable|string|max:255',
            'pages' => 'nullable|integer',
            'language' => 'nullable|string|max:255',
            'edition' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'discount_price' => 'nullable|numeric',
            'stock' => 'nullable|integer',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:product_categories,id',
            'cover_image' => 'nullable|image|max:2048', // 2MB max
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'seo' => 'nullable|array',
            'seo.meta_title' => 'nullable|string|max:255',
            'seo.meta_description' => 'nullable|string|max:255',
            'seo.meta_keywords' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        // Handle cover image
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('products/covers', 'public');
            $data['cover_image'] = $path;
        }

        // Handle product images
        if ($request->hasFile('images')) {
            $imagesData = [];
            $images = $request->file('images');

            foreach ($images as $index => $image) {
                $path = $image->store('products/gallery', 'public');
                $isPrimary = isset($data['primary_image']) && $data['primary_image'] == $index;

                $imagesData[] = [
                    'image_path' => $path,
                    'caption' => $request->input('image_captions.' . $index, null),
                    'is_primary' => $isPrimary,
                    'order' => $index
                ];
            }

            $data['images'] = $imagesData;
        }

        $product = $this->productService->create($data);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    /**
     * Update a product
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $id,
            'description' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'publish_date' => 'nullable|date',
            'isbn' => 'nullable|string|max:255',
            'dimensions' => 'nullable|string|max:255',
            'pages' => 'nullable|integer',
            'language' => 'nullable|string|max:255',
            'edition' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'discount_price' => 'nullable|numeric',
            'stock' => 'nullable|integer',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:product_categories,id',
            'cover_image' => 'nullable|image|max:2048', // 2MB max
            'new_images' => 'nullable|array',
            'new_images.*' => 'image|max:2048',
            'update_images' => 'nullable|array',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer',
            'seo' => 'nullable|array',
            'seo.meta_title' => 'nullable|string|max:255',
            'seo.meta_description' => 'nullable|string|max:255',
            'seo.meta_keywords' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        // Handle cover image
        if ($request->hasFile('cover_image')) {
            $product = $this->productService->findById($id);

            // Delete old cover image if exists
            if ($product && $product->cover_image) {
                Storage::disk('public')->delete($product->cover_image);
            }

            $path = $request->file('cover_image')->store('products/covers', 'public');
            $data['cover_image'] = $path;
        }

        // Handle new product images
        if ($request->hasFile('new_images')) {
            $imagesData = [];
            $images = $request->file('new_images');

            foreach ($images as $index => $image) {
                $path = $image->store('products/gallery', 'public');
                $isPrimary = isset($data['primary_image']) && $data['primary_image'] == 'new_' . $index;

                $imagesData[] = [
                    'image_path' => $path,
                    'caption' => $request->input('new_image_captions.' . $index, null),
                    'is_primary' => $isPrimary,
                    'order' => $index
                ];
            }

            $data['new_images'] = $imagesData;
        }

        $product = $this->productService->update($id, $data);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ]);
    }

    /**
     * Delete a product (soft delete)
     */
    public function destroy($id)
    {
        $result = $this->productService->delete($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }

    /**
     * Force delete a product
     */
    public function forceDelete($id)
    {
        $result = $this->productService->forceDelete($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product permanently deleted'
        ]);
    }

    /**
     * Restore a soft deleted product
     */
    public function restore($id)
    {
        $result = $this->productService->restore($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product restored successfully'
        ]);
    }

    /**
     * Update product stock
     */
    public function updateStock(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
            'operation' => 'required|in:add,subtract',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->productService->updateStock(
            $id,
            $request->input('quantity'),
            $request->input('operation')
        );

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Stock updated successfully'
        ]);
    }
}
