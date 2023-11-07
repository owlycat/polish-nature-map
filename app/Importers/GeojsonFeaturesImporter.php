<?php

namespace App\Importers;

use App\Events\GeojsonFeatureImporterRunEvent;
use App\Models\Category;
use App\Models\SpatialFeature;

abstract class GeojsonFeaturesImporter
{
    protected function __construct(
        protected string $categoryName
    ) {}

    public function getCategoryName(): string {
        return $this->categoryName;
    }

    public function run(): void{
        $category = Category::firstOrCreate(['name' => $this->getCategoryName()]);

        $features = $this->getFeatures();
        // todo
    }

    abstract public function getFeatures(): array;
}
