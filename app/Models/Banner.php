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
        'desktop_image',
        'mobile_image',
    ];

    public function setDesktopImageAttribute($value)
    {
        $this->attributes['desktop_image'] = $value->store('assets/banners', 'public');
    }

    public function setMobileImageAttribute($value)
    {
        $this->attributes['mobile_image'] = $value->store('assets/banners', 'public');
    }
}
