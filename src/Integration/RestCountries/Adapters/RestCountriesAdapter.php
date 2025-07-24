<?php

namespace App\Integration\RestCountries\Adapters;

use App\Integration\RestCountries\Endpoints\AllRestCountriesEndpoint;

class RestCountriesAdapter implements RestCountriesAdapterInterface
{
    public function __construct(
        private readonly AllRestCountriesEndpoint $endpoint
    ) {}

    /**
     * {@inheritdoc}
     */
    public function fetchAllCountries(): array
    {
        $rawData = $this->endpoint->fetchAll();
        $transformedData = [];
        
        foreach ($rawData as $countryData) {
            // Skip countries that don't have required fields
            if (!isset($countryData['name']['common'], $countryData['region'], $countryData['flags']['svg'])) {
                continue;
            }
            
            $currencyCode = array_key_first($countryData['currencies'] ?? []);
            $currencyData = $currencyCode ? ($countryData['currencies'][$currencyCode] ?? []) : [];
            
            $transformedData[] = [
                'name' => $countryData['name']['common'],
                'region' => $countryData['region'] ?? 'Unknown',
                'subRegion' => $countryData['subregion'] ?? 'Unknown',
                'demonym' => $countryData['demonyms']['eng']['m'] ?? $countryData['name']['common'],
                'population' => (int) ($countryData['population'] ?? 0),
                'independant' => (bool) ($countryData['independent'] ?? false),
                'flag' => $countryData['flags']['svg'] ?? '',
                'currencyName' => $currencyCode ?: 'N/A',
                'currencySymbol' => $currencyData['symbol'] ?? ''
            ];
        }
        
        return $transformedData;
    }
}