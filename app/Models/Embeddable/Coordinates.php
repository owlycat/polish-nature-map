<?php
namespace App\Models\Embeddable;

use Spatie\LaravelData\Data;

class Coordinates extends Data
{
    public function __construct(
        public readonly float $lat,
        public readonly float $lng,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            lat: $data[1],
            lng: $data[0]
        );
    }
}