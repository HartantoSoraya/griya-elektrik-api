<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebConfiguration extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'title',
        'description',
        'email',
        'phone',
        'logo',
        'map',
        'address',
        'facebook',
        'instagram',
        'youtube',
    ];

    public function setLogoAttribute($value)
    {
        if ($value != 'undefined') {
            $this->attributes['logo'] = $value->store('assets/web-configurations', 'public');
        }
    }
}
