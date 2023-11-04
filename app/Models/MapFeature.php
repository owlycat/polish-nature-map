<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Category;
use Laravel\Scout\Searchable;

class MapFeature extends Model
{
    use HasFactory;
    use Searchable;

    protected $casts = [
        "name" => "string",
        "_geo" => "array",
    ];

    protected $fillable = [
        "name",
        "_geo",
        "category_id",
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
