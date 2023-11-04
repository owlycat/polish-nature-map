<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\SpatialFeature;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
    ];

    public function spatialFeatures(): HasMany
    {
        return $this->HasMany(SpatialFeature::class);
    }

    public static function createCategoryIfNotExists($name): Category
    {
        return self::firstOrCreate(['name' => $name]);
    }
}
