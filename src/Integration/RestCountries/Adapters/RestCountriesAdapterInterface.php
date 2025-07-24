<?php

namespace App\Integration\RestCountries\Adapters;

interface RestCountriesAdapterInterface
{
    /**
     * Fetch all countries data from the API
     * 
     * @return array The array of country data
     */
    public function fetchAllCountries(): array;
}