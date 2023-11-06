<?php

namespace App\Importers;

use App\Importers\SpatialFeaturesImporter;

use App\Helpers\Facades\GeojsonFeatureFacade;
use App\DataSources\GDOSDataSource;
use GeojsonFeature;

class LandscapeParkImporter extends SpatialFeaturesImporter {

    protected string $categoryName = "landscape_park";

    public function __construct() {
        parent::__construct($this->categoryName);
    }

    public function getFeatures(): array {
        return [];
        $dataSource = new GDOSDataSource();

        $features = $dataSource->getData([ "typeName" => "GDOS:ParkiKrajobrazowe" ]);

        $features = GeojsonFeature::excludeFeaturesHasPhrase(phrase: "otulina", geojson: $features, paramName: "nazwa");
        $features = GeojsonFeature::convertToPoints($features);
        $features = GeojsonFeature::convertCrs($features, "2180", "4326");

        return $features;
    }
}
