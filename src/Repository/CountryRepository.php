<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Uid\Uuid;

class CountryRepository extends EntityRepository implements CountryRepositoryInterface
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Country::class));
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        return parent::findAll();
    }

    /**
     * @inheritDoc
     */
    public function findByUuid(Uuid $uuid): ?Country
    {
        return $this->findOneBy(['uuid' => $uuid]);
    }

    /**
     * @inheritDoc
     */
    public function findByName(string $name): ?Country
    {
        return $this->findOneBy(['name' => $name]);
    }

    /**
     * @inheritDoc
     */
    public function save(Country $country): void
    {
        $this->getEntityManager()->persist($country);
        $this->getEntityManager()->flush();
    }

    /**
     * @inheritDoc
     */
    public function remove(Country $country): void
    {
        $this->getEntityManager()->remove($country);
        $this->getEntityManager()->flush();
    }
    
}