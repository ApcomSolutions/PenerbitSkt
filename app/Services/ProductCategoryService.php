<?php

namespace App\Services;

use App\Models\ProductCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductCategoryService
{
    /**
     * Get all active categories
     *
     * @return Collection
     */
    public function getAllActive(): Collection
    {
        return ProductCategory::where('is_active', true)
            ->orderBy('order')
            ->get();
    }

    /**
     * Get all categories, optionally paginated
     *
     * @param int $perPage
     * @return Collection|LengthAwarePaginator
     */
    public function getAll(int $perPage = 0)
    {
        $query = ProductCategory::orderBy('order');

        return $perPage > 0 ? $query->paginate($perPage) : $query->get();
    }

    /**
     * Find category by ID
     *
     * @param int $id
     * @return ProductCategory|null
     */
    public function findById(int $id): ?ProductCategory
    {
        return ProductCategory::find($id);
    }

    /**
     * Find category by slug
     *
     * @param string $slug
     * @return ProductCategory|null
     */
    public function findBySlug(string $slug): ?ProductCategory
    {
        return ProductCategory::where('slug', $slug)->first();
    }

    /**
     * Create a new category
     *
     * @param array $data
     * @return ProductCategory
     */
    public function create(array $data): ProductCategory
    {
        if (!isset($data['slug']) || empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        return ProductCategory::create($data);
    }

    /**
     * Update a category
     *
     * @param int $id
     * @param array $data
     * @return ProductCategory|null
     */
    public function update(int $id, array $data): ?ProductCategory
    {
        $category = $this->findById($id);
        if (!$category) {
            return null;
        }

        if (isset($data['name']) && (!isset($data['slug']) || empty($data['slug']))) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->update($data);
        return $category;
    }

    /**
     * Delete a category
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $category = $this->findById($id);
        if (!$category) {
            return false;
        }

        return $category->delete();
    }
}
