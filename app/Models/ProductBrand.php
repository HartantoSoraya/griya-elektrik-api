<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBrand extends Model
{
    use HasFactory, UUID;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'logo',
        'slug',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
