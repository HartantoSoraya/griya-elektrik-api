<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProductBrand extends Model
{
    use HasFactory, UUID;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
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
