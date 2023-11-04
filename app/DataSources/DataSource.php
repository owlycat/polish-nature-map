<?php

namespace App\DataSources;

class DataSource {
    protected string $name;

    protected function __construct(string $name) {
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getData(mixed $data = null): array {
        return [];
    }
}
