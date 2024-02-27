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
        'logo',
    ];
}
