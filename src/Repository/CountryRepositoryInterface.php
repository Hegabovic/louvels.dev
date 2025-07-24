<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Country;
use Symfony\Component\Uid\Uuid;

interface CountryRepositoryInterface
{
    /**
     * Find all countries
     *
     * @return Country[]
     */
    public function findAll(): array;
    
    /**
     * Find a country by its UUID
     *
     * @param Uuid $uuid
     * @return Country|null
     */
    public function findByUuid(Uuid $uuid): ?Country;
    
    /**
     * Find a country by its name
     *
     * @param string $name
     * @return Country|null
     */
    public function findByName(string $name): ?Country;
    
    /**
     * Save a country entity
     *
     * @param Country $country
     * @return void
     */
    public function save(Country $country): void;
    
    /**
     * Remove a country entity
     *
     * @param Country $country
     * @return void
     */
    public function remove(Country $country): void;
}