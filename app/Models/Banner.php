<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory, UUID;
    use SoftDeletes;

    protected $fillable = [
        'image',
    ];

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = $value->store('assets/banners', 'public');
    }
}
