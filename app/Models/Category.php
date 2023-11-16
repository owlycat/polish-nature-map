<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'image',
    ];

    public function spatialFeatures(): HasMany
    {
        return $this->HasMany(SpatialFeature::class);
    }
}
