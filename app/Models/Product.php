<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, UUID;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'product_category_id',
        'product_brand_id',
        'name',
        'thumbnail',
        'description',
        'price',
        'is_featured',
        'is_active',
        'slug',
    ];

    protected $casts = [
        'price' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class, 'product_brand_id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productLinks()
    {
        return $this->hasMany(ProductLink::class);
    }
}
