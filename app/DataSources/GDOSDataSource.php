<?php

namespace App\DataSources;

use App\DataSources\DataSource;
use Illuminate\Support\Facades\Http;
use App\Exceptions\CouldNotFetchDataException;

class GDOSDataSource extends DataSource {

    protected string $name = 'Usługa pobierania (Web Feature Service) Generalnej Dyrekcji Ochrony Środowiska';

    public function __construct() {
        parent::__construct($this->name);
    }

    public function getData(mixed $data = null): array {

        $url = 'https://sdi.gdos.gov.pl/wfs';

        $params = [
            'service' => 'WFS',
            'version' => '2.0.0',
            'request' => 'GetFeature',
            'typeName' => $data['typeName'],
            'outputFormat' => 'application/json',
        ];

        try {
            $response = Http::withoutVerifying()->retry(3, 100)
            ->timeout(10)
            ->get($url, $params);

            if ($response->successful()) {
                return $response->json();
            }
        } catch (RequestException $e) {
            throw new CouldNotFetchDataException($e->getMessage());
        }
    }
}
