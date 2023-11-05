<?php

namespace App\DataSources;

abstract class DataSource {
    protected string $name;

    protected function __construct(string $name) {
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }

    abstract public function getData(mixed $data = null): array;
}
