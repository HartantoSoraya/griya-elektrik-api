<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductLink extends Model
{
    use HasFactory, UUID;
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'name',
        'url',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
