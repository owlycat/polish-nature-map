<?php

namespace App\Importers;

use App\Events\GeojsonFeatureImporterRunEvent;
use App\Models\Category;
use App\Models\SpatialFeature;

abstract class GeojsonFeaturesImporter
{
    public function getCategoryName(): string {
        return static::CATEGORY_NAME;
    }

    public function run(): void{
        $category = Category::firstOrCreate(['name' => $this->getCategoryName()]);

        $features = $this->getFeatures();
        // todo
    }

    abstract public function getFeatures(): array;
}
