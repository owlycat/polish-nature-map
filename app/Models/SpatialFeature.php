<?php

namespace App\Models;

use App\Models\Embeddable\Coordinates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class SpatialFeature extends Model
{
    use HasFactory;
    use Searchable;

    protected $casts = [
        'name' => 'string',
        '_geo' => Coordinates::class,
    ];

    protected $fillable = [
        'name',
        '_geo',
        'description',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            '_geo' => $this->_geo,
        ];
    }

    public function searchableAs(): string
    {
        return 'features_index';
    }
}
