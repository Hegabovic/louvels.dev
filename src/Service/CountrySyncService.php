<?php

namespace App\Service;

use App\Entity\Country;
use App\Integration\RestCountries\Adapters\RestCountriesAdapterInterface;
use Doctrine\ORM\EntityManagerInterface;

readonly class CountrySyncService
{
    public function __construct(
        private RestCountriesAdapterInterface $countriesAdapter,
        private EntityManagerInterface        $em,
    ) {}

    public function sync(): void
    {
        $countries = $this->countriesAdapter->fetchAllCountries();

        foreach ($countries as $countryData) {
            $country = $this->em->getRepository(Country::class)->findOneBy(['name' => $countryData['name']]);

            if (!$country) {
                $country = new Country();
            }

            $country
                ->setName($countryData['name'])
                ->setRegion($countryData['region'])
                ->setSubRegion($countryData['subRegion'])
                ->setDemonym($countryData['demonym'])
                ->setPopulation($countryData['population'])
                ->setIndependant($countryData['independant'])
                ->setFlag($countryData['flag'])
                ->setCurrencyName($countryData['currencyName'])
                ->setCurrencySymbol($countryData['currencySymbol']);

            $this->em->persist($country);
        }

        $this->em->flush();
    }
}
