<?php

namespace App\Models\Embeddable;

use Spatie\LaravelData\Data;

class Coordinates extends Data
{
    public function __construct(
        public readonly float $lat,
        public readonly float $lng,
    ) {
    }

    public static function fromArray(array $data): self
    {
        if (isset($data['lat']) && isset($data['lng'])) {
            return new self(
                lat: $data['lat'],
                lng: $data['lng']
            );
        }

        return new self(
            lat: $data[1],
            lng: $data[0]
        );
    }

    public function toArray(): array
    {
        return [$this->lng, $this->lat];
    }
}
