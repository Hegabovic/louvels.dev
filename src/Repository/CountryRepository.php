<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class CountryRepository implements CountryRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {}

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        return $this->entityManager->getRepository(Country::class)->findAll();
    }

    /**
     * @inheritDoc
     */
    public function findByUuid(Uuid $uuid): ?Country
    {
        return $this->entityManager->getRepository(Country::class)->findOneBy(['uuid' => $uuid]);
    }

    /**
     * @inheritDoc
     */
    public function findByName(string $name): ?Country
    {
        return $this->entityManager->getRepository(Country::class)->findOneBy(['name' => $name]);
    }

    /**
     * @inheritDoc
     */
    public function save(Country $country): void
    {
        $this->entityManager->persist($country);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function remove(Country $country): void
    {
        $this->entityManager->remove($country);
        $this->entityManager->flush();
    }
}