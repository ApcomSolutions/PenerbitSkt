<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'author',
        'publisher',
        'publish_date',
        'isbn',
        'cover_image',
        'dimensions',
        'pages',
        'language',
        'edition',
        'price',
        'discount_price',
        'stock',
        'is_featured',
        'is_published'
    ];

    protected $casts = [
        'publish_date' => 'date',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'product_category');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function seo()
    {
        return $this->hasOne(ProductSeo::class);
    }
}
