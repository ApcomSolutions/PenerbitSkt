<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSeo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    /**
     * Get all published products
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllPublished(int $perPage = 12): LengthAwarePaginator
    {
        return Product::with(['categories', 'images' => function($query) {
            $query->where('is_primary', true);
        }])
            ->where('is_published', true)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get featured products
     *
     * @param int $limit
     * @return Collection
     */
    public function getFeatured(int $limit = 8): Collection
    {
        return Product::with(['categories', 'images' => function($query) {
            $query->where('is_primary', true);
        }])
            ->where('is_published', true)
            ->where('is_featured', true)
            ->latest()
            ->limit($limit)
            ->get();
    }
    /**
     * Get all products for admin
     *
     * @param int $perPage
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function getAll(int $perPage = 15, array $params = []): LengthAwarePaginator
    {
        // Periksa parameter trashed
        if (isset($params['trashed']) && $params['trashed'] === 'only') {
            $query = Product::onlyTrashed();
        } else {
            $query = Product::query();
        }

        // Tambahkan relations
        $query->with(['categories', 'images' => function($query) {
            $query->where('is_primary', true);
        }]);

        // Tambahkan pencarian jika ada
        if (isset($params['search']) && !empty($params['search'])) {
            $search = $params['search'];
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhere('author', 'like', "%$search%");
            });
        }

        // Tambahkan filter kategori jika ada
        if (isset($params['category']) && !empty($params['category'])) {
            $query->whereHas('categories', function($q) use ($params) {
                $q->where('product_categories.id', $params['category']);
            });
        }

        // Tambahkan filter status jika ada
        if (isset($params['status'])) {
            if ($params['status'] === 'published') {
                $query->where('is_published', true);
            } elseif ($params['status'] === 'draft') {
                $query->where('is_published', false);
            } elseif ($params['status'] === 'featured') {
                $query->where('is_featured', true);
            }
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Find product by ID with relationships
     *
     * @param int $id
     * @return Product|null
     */
    public function findById(int $id): ?Product
    {
        return Product::with(['categories', 'images', 'seo'])
            ->find($id);
    }

    /**
     * Find product by slug
     *
     * @param string $slug
     * @return Product|null
     */
    public function findBySlug(string $slug): ?Product
    {
        return Product::with(['categories', 'images', 'seo'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->first();
    }

    /**
     * Create a new product with relations
     *
     * @param array $data
     * @return Product|null
     */
    public function create(array $data): ?Product
    {
        try {
            DB::beginTransaction();

            // Format the data properly
            if (!isset($data['slug']) || empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }

            // Create product
            $product = Product::create($data);

            // Attach categories if any
            if (isset($data['categories']) && is_array($data['categories'])) {
                $product->categories()->attach($data['categories']);
            }

            // Handle SEO data if any
            if (isset($data['seo']) && is_array($data['seo'])) {
                $product->seo()->create($data['seo']);
            }

            // Handle images if any
            if (isset($data['images']) && is_array($data['images'])) {
                foreach ($data['images'] as $image) {
                    $product->images()->create($image);
                }
            }

            DB::commit();
            return $product->fresh(['categories', 'images', 'seo']);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to create product: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Update a product with relations
     *
     * @param int $id
     * @param array $data
     * @return Product|null
     */
    public function update(int $id, array $data): ?Product
    {
        try {
            DB::beginTransaction();

            $product = $this->findById($id);
            if (!$product) {
                return null;
            }

            // Format the data properly
            if (isset($data['title']) && (!isset($data['slug']) || empty($data['slug']))) {
                $data['slug'] = Str::slug($data['title']);
            }

            // Update product
            $product->update($data);

            // Sync categories if any
            if (isset($data['categories']) && is_array($data['categories'])) {
                $product->categories()->sync($data['categories']);
            }

            // Update SEO data if any
            if (isset($data['seo']) && is_array($data['seo'])) {
                if ($product->seo) {
                    $product->seo->update($data['seo']);
                } else {
                    $product->seo()->create($data['seo']);
                }
            }

            // Handle images if any new ones
            if (isset($data['new_images']) && is_array($data['new_images'])) {
                foreach ($data['new_images'] as $image) {
                    $product->images()->create($image);
                }
            }

            // Handle image updates
            if (isset($data['update_images']) && is_array($data['update_images'])) {
                foreach ($data['update_images'] as $imageId => $imageData) {
                    $image = ProductImage::find($imageId);
                    if ($image && $image->product_id == $product->id) {
                        $image->update($imageData);
                    }
                }
            }

            // Handle image deletions
            if (isset($data['delete_images']) && is_array($data['delete_images'])) {
                foreach ($data['delete_images'] as $imageId) {
                    $image = ProductImage::find($imageId);
                    if ($image && $image->product_id == $product->id) {
                        // Delete the file if it exists
                        if (Storage::exists('public/' . $image->image_path)) {
                            Storage::delete('public/' . $image->image_path);
                        }
                        $image->delete();
                    }
                }
            }

            DB::commit();
            return $product->fresh(['categories', 'images', 'seo']);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to update product: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Soft delete a product
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $product = $this->findById($id);
        if (!$product) {
            return false;
        }

        return $product->delete();
    }

    /**
     * Permanently delete a product
     *
     * @param int $id
     * @return bool
     */
    public function forceDelete(int $id): bool
    {
        $product = Product::withTrashed()->find($id);
        if (!$product) {
            return false;
        }

        try {
            DB::beginTransaction();

            // Delete images files
            foreach ($product->images as $image) {
                if (Storage::exists('public/' . $image->image_path)) {
                    Storage::delete('public/' . $image->image_path);
                }
            }

            // Delete relationships will cascade automatically due to foreign key constraints
            $result = $product->forceDelete();

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Failed to force delete product: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Restore a soft deleted product
     *
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        $product = Product::withTrashed()->find($id);
        if (!$product) {
            return false;
        }

        return $product->restore();
    }

    /**
     * Update product stock
     *
     * @param int $id
     * @param int $quantity
     * @param string $operation 'add' or 'subtract'
     * @return bool
     */
    public function updateStock(int $id, int $quantity, string $operation = 'add'): bool
    {
        $product = $this->findById($id);
        if (!$product) {
            return false;
        }

        if ($operation === 'add') {
            $product->stock += $quantity;
        } else {
            $product->stock = max(0, $product->stock - $quantity);
        }

        return $product->save();
    }
}
