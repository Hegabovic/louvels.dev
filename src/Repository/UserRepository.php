<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {}

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        return $this->entityManager->getRepository(User::class)->findAll();
    }

    /**
     * @inheritDoc
     */
    public function findByUuid(Uuid $uuid): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['uuid' => $uuid]);
    }

    /**
     * @inheritDoc
     */
    public function findByEmail(string $email): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    /**
     * @inheritDoc
     */
    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function remove(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}