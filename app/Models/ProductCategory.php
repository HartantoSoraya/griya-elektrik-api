<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use HasFactory, UUID;
    use SoftDeletes;

    protected $fillable = [
        'parent_id',
        'code',
        'name',
        'slug',
    ];

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public static function getRootCategories()
    {
        return static::with('childrenRecursive')->whereNull('parent_id')->get();
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id', 'id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function isLeaf()
    {
        return $this->children->isEmpty();
    }

    public static function getLeafCategories()
    {
        return static::whereDoesntHave('children')->get();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public static function getEmptyCategories()
    {
        return self::doesntHave('products')->get();
    }

    public function setSlugAttribute($value)
    {
        if ($value) {
            $this->attributes['slug'] = $value;
        } else {
            $this->attributes['slug'] = Str::slug($this->attributes['name'].$this->attributes['code']);
        }
    }
}
