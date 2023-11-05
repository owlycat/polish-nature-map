<?php

namespace App\Importers;

use App\Events\SpatialFeatureImporterRunEvent;
use App\Models\Category;
use App\Models\SpatialFeature;

abstract class SpatialFeaturesImporter {

    protected string $categoryName;

    protected function __construct(string $categoryName) {
        $this->categoryName = $categoryName;
    }

    public function getCategoryName(): string {
        return $this->categoryName;
    }

    public function run(): void{
        Category::createCategoryIfNotExists($this->categoryName);

        $features = $this->getFeatures();

        // todo
    }

    abstract public function getFeatures(): array;
}
