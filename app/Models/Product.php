<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, UUID;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'slug',
        'product_category_id',
        'product_brand_id',
        'name',
        'description',
        'price',
        'is_active',
    ];

    protected $casts = [
        'price' => 'integer',
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
        return $this->hasMany(productImage::class);
    }

    public function setSlugAttribute($value)
    {
        if ($value) {
            $this->attributes['slug'] = $value;
        } else {
            $this->attributes['slug'] = Str::slug($this->attributes['name'].$this->attributes['code']);
        }
    }

    public function setThumbnailAttribute($value)
    {
        $this->attributes['thumbnail'] = $value->store('assets/products', 'public');
    }
}
