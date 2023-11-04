<?php

namespace App\Importers;

use App\Importers\SpatialFeaturesImporter;

use App\Helpers\Facades\GeojsonFeatureFacade;
use App\DataSources\GDOSDataSource;
use GeojsonFeature;

class NationalParkImporter extends SpatialFeaturesImporter {
    protected string $categoryName = "national_park";

    public function __construct() {
        parent::__construct($this->categoryName);
    }

    public function getFeatures(): array {
        $dataSource = new GDOSDataSource();

        $features = $dataSource->getData([ "typeName" => "GDOS:ParkiNarodowe" ]);

        $features = GeojsonFeature::excludeFeaturesHasPhrase(phrase: "otulina", geojson: $features, paramName: "nazwa");
        $features = GeojsonFeature::convertToPoints($features);
        $features = GeojsonFeature::convertCrs($features, "2180", "4326");

        return $features;
    }
}