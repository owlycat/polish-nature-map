<?php

namespace App\Models;

use App\Models\Embeddable\Coordinates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function visitors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'visited_places')->withTimestamps();
    }

    public function searchableAs(): string
    {
        return 'features_index';
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category->name,
            'description' => $this->description,
        ];
    }

    protected function makeAllSearchableUsing($query)
    {
        return $query->with('category');
    }
}
