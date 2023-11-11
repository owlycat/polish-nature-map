<?php

namespace App\Models;

use App\Models\Embeddable\Coordinates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpatialFeature extends Model
{
    use HasFactory;

    protected $casts = [
        'name' => 'string',
        '_geo' => Coordinates::class,
    ];

    protected $fillable = [
        'name',
        '_geo',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
