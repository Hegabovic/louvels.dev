<?php

namespace App\Integration\RestCountries\Endpoints;

use Symfony\Contracts\HttpClient\HttpClientInterface;
class AllRestCountriesEndpoint
{
    private string $baseUrl;

    public function __construct(private readonly HttpClientInterface $httpClient, string $baseUrl)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function fetchAll(): array
    {
        $response = $this->httpClient->request('GET', $this->baseUrl . '/all');
        return $response->toArray();
    }

}