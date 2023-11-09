<?php

namespace App\Importers;

use App\Events\GeojsonFeatureImporterRunEvent;
use App\Models\Category;
use App\Models\SpatialFeature;
use Illuminate\Support\Facades\DB;
use App\Models\Embeddable\Coordinates;

abstract class GeojsonFeaturesImporter
{
    public function getCategoryName(): string {
        return static::CATEGORY_NAME;
    }

    public function run(): void{
        try {
            DB::beginTransaction();

            $category = Category::firstOrCreate(['name' => $this->getCategoryName()]);

            $features = $this->getFeatures();

            foreach ($features['features'] as $feature) {
                $spatialFeature = SpatialFeature::updateOrCreate(
                    ["name" => $feature['properties']['name']],
                    [
                        "_geo" => Coordinates::fromArray($feature['geometry']['coordinates']),
                        "category_id" => $category->id,
                    ]
                );
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    abstract public function getFeatures(): array;
}
