<?php

namespace App\Importers;

use App\DataSources\GDOSDataSource;
use GeojsonFeature;

class NationalParkImporter extends GeojsonFeaturesImporter
{
    const CATEGORY_NAME = 'national_park';

    public function getFeatures(): array
    {
        $dataSource = new GDOSDataSource();

        $features = $dataSource->getData(['typeName' => 'GDOS:ParkiNarodowe']);

        $features = GeojsonFeature::excludeFeaturesHasPhrase(phrase: 'otulina', geojson: $features, paramName: 'nazwa');
        $features = GeojsonFeature::convertToPoints($features);
        $features = GeojsonFeature::convertCrs($features, '2180', '4326');
        $features = GeojsonFeature::renameProperty($features, 'nazwa', 'name');

        return $features;
    }
}
