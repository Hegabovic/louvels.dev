<?php
declare(strict_types=1);

namespace App\Controller\V1;

use App\Entity\Country;
use App\Repository\CountryRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

#[Route('/api/v1/countries')]
class CountryController extends AbstractController
{
    public function __construct(
        private readonly CountryRepositoryInterface $countryRepository
    ) {}

    #[Route('/{country}', methods: ['GET'])]
    public function getCountry(string $country): JsonResponse
    {
        // Try to find country by UUID first, then by name if UUID is invalid
        try {
            $countryEntity = $this->countryRepository->findByUuid(Uuid::fromString($country));
        } catch (\Exception $e) {
            // If UUID is invalid, try to find by name
            $countryEntity = $this->countryRepository->findByName($country);
        }
        
        if (!$countryEntity) {
            return $this->json(['error' => 'Country not found'], Response::HTTP_NOT_FOUND);
        }
        
        return $this->json([
            'uuid' => $countryEntity->getUuid()->toRfc4122(),
            'name' => $countryEntity->getName(),
            'region' => $countryEntity->getRegion(),
            'subRegion' => $countryEntity->getSubRegion(),
            'demonym' => $countryEntity->getDemonym(),
            'population' => $countryEntity->getPopulation(),
            'independant' => $countryEntity->isIndependant(),
            'flag' => $countryEntity->getFlag(),
            'currencyName' => $countryEntity->getCurrencyName(),
            'currencySymbol' => $countryEntity->getCurrencySymbol(),
        ]);
    }

    #[Route('', methods: ['GET'])]
    public function getCountries(): JsonResponse
    {
        $countries = $this->countryRepository->findAll();
        
        $result = [];
        foreach ($countries as $country) {
            $result[] = [
                'uuid' => $country->getUuid()->toRfc4122(),
                'name' => $country->getName(),
                'region' => $country->getRegion(),
                'subRegion' => $country->getSubRegion(),
                'demonym' => $country->getDemonym(),
                'population' => $country->getPopulation(),
                'independant' => $country->isIndependant(),
                'flag' => $country->getFlag(),
                'currencyName' => $country->getCurrencyName(),
                'currencySymbol' => $country->getCurrencySymbol(),
            ];
        }
        
        return $this->json($result);
    }

    #[Route('', methods: ['POST'])]
    public function addCountry(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        // Check if country already exists (business logic validation)
        $existingCountry = $this->countryRepository->findByName($data['name']);
        if ($existingCountry) {
            return $this->json(['error' => 'Country with this name already exists'], Response::HTTP_CONFLICT);
        }
        
        $country = new Country();
        $country->setName($data['name']);
        $country->setRegion($data['region'] ?? '');
        $country->setSubRegion($data['subRegion'] ?? '');
        $country->setDemonym($data['demonym'] ?? '');
        $country->setPopulation($data['population'] ?? 0);
        $country->setIndependant($data['independant'] ?? false);
        $country->setFlag($data['flag'] ?? '');
        $country->setCurrencyName($data['currencyName'] ?? '');
        $country->setCurrencySymbol($data['currencySymbol'] ?? '');
        
        $this->countryRepository->save($country);
        
        return $this->json([
            'uuid' => $country->getUuid()->toRfc4122(),
            'name' => $country->getName(),
            'region' => $country->getRegion(),
            'subRegion' => $country->getSubRegion(),
            'demonym' => $country->getDemonym(),
            'population' => $country->getPopulation(),
            'independant' => $country->isIndependant(),
            'flag' => $country->getFlag(),
            'currencyName' => $country->getCurrencyName(),
            'currencySymbol' => $country->getCurrencySymbol(),
        ], Response::HTTP_CREATED);
    }

    #[Route('/{country}', methods: ['PATCH'])]
    public function updateCountry(string $country, Request $request): JsonResponse
    {
        // Try to find country by UUID first, then by name if UUID is invalid
        try {
            $countryEntity = $this->countryRepository->findByUuid(Uuid::fromString($country));
        } catch (\Exception $e) {
            // If UUID is invalid, try to find by name
            $countryEntity = $this->countryRepository->findByName($country);
        }
        
        if (!$countryEntity) {
            return $this->json(['error' => 'Country not found'], Response::HTTP_NOT_FOUND);
        }
        
        $data = json_decode($request->getContent(), true);
        $updatedFields = [];
        
        // Check for name conflicts if name is being updated (business logic validation)
        if (isset($data['name']) && $data['name'] !== $countryEntity->getName()) {
            $existingCountry = $this->countryRepository->findByName($data['name']);
            if ($existingCountry && $existingCountry->getUuid()->toRfc4122() !== $countryEntity->getUuid()->toRfc4122()) {
                return $this->json(['error' => 'Country with this name already exists'], Response::HTTP_CONFLICT);
            }
            $countryEntity->setName($data['name']);
            $updatedFields[] = 'name';
        }
        
        if (isset($data['region'])) {
            $countryEntity->setRegion($data['region']);
            $updatedFields[] = 'region';
        }
        
        if (isset($data['subRegion'])) {
            $countryEntity->setSubRegion($data['subRegion']);
            $updatedFields[] = 'subRegion';
        }
        
        if (isset($data['demonym'])) {
            $countryEntity->setDemonym($data['demonym']);
            $updatedFields[] = 'demonym';
        }
        
        if (isset($data['population'])) {
            $countryEntity->setPopulation((int)$data['population']);
            $updatedFields[] = 'population';
        }
        
        if (isset($data['independant'])) {
            $countryEntity->setIndependant((bool)$data['independant']);
            $updatedFields[] = 'independant';
        }
        
        if (isset($data['flag'])) {
            $countryEntity->setFlag($data['flag']);
            $updatedFields[] = 'flag';
        }
        
        if (isset($data['currencyName'])) {
            $countryEntity->setCurrencyName($data['currencyName']);
            $updatedFields[] = 'currencyName';
        }
        
        if (isset($data['currencySymbol'])) {
            $countryEntity->setCurrencySymbol($data['currencySymbol']);
            $updatedFields[] = 'currencySymbol';
        }
        
        // If no fields were updated, return a message
        if (empty($updatedFields)) {
            return $this->json(['message' => 'No fields were updated'], Response::HTTP_OK);
        }
        
        $this->countryRepository->save($countryEntity);
        
        return $this->json([
            'message' => 'Country updated successfully',
            'updated_fields' => $updatedFields,
            'data' => [
                'uuid' => $countryEntity->getUuid()->toRfc4122(),
                'name' => $countryEntity->getName(),
                'region' => $countryEntity->getRegion(),
                'subRegion' => $countryEntity->getSubRegion(),
                'demonym' => $countryEntity->getDemonym(),
                'population' => $countryEntity->getPopulation(),
                'independant' => $countryEntity->isIndependant(),
                'flag' => $countryEntity->getFlag(),
                'currencyName' => $countryEntity->getCurrencyName(),
                'currencySymbol' => $countryEntity->getCurrencySymbol(),
            ]
        ]);
    }

    #[Route('/{country}', methods: ['DELETE'])]
    public function deleteCountry(string $country): JsonResponse
    {
        // Try to find country by UUID first, then by name if UUID is invalid
        try {
            $countryEntity = $this->countryRepository->findByUuid(Uuid::fromString($country));
        } catch (\Exception $e) {
            // If UUID is invalid, try to find by name
            $countryEntity = $this->countryRepository->findByName($country);
        }
        
        if (!$countryEntity) {
            return $this->json(['error' => 'Country not found'], Response::HTTP_NOT_FOUND);
        }
        
        $this->countryRepository->remove($countryEntity);
        
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}