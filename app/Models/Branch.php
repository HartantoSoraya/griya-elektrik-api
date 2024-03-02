<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, UUID;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'map_url',
        'iframe_map',
        'address',
        'city',
        'email',
        'phone',
        'facebook',
        'instagram',
        'youtube',
        'sort',
        'is_main',
        'is_active',
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'is_active' => 'boolean',
        'sort' => 'integer'
    ];

    public function branchImages()
    {
        return $this->hasMany(BranchImage::class);
    }
}
