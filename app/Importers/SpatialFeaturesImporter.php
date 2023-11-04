<?php

namespace App\Importers;

use App\Events\SpatialFeatureImporterRunEvent;
use App\Model\Category;
use App\Model\SpatialFeature;

abstract class SpatialFeaturesImporter {

    protected string $categoryName;

    protected function __construct(string $categoryName) {
        $this->categoryName = $categoryName;

        $this->createCategory($categoryName);
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
