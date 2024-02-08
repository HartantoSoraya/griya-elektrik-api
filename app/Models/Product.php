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
        return $this->belongsTo(ProductCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class);
    }

    public function productImages()
    {
        return $this->hasMany(productImage::class);
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = Str::upper(Str::random(10));
    }
}
