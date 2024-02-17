<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchImage extends Model
{
    use HasFactory, UUID;
    use SoftDeletes;

    protected $fillable = [
        'branch_id',
        'image',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = $value->store('assets/branches', 'public');
    }
}
