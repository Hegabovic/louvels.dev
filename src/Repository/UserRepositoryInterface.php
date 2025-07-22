<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;

interface UserRepositoryInterface
{
    /**
     * Find all users
     *
     * @return User[]
     */
    public function findAll(): array;
    
    /**
     * Find a user by its UUID
     *
     * @param Uuid $uuid
     * @return User|null
     */
    public function findByUuid(Uuid $uuid): ?User;
    
    /**
     * Find a user by its email
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;
    
    /**
     * Save a user entity
     *
     * @param User $user
     * @return void
     */
    public function save(User $user): void;
    
    /**
     * Remove a user entity
     *
     * @param User $user
     * @return void
     */
    public function remove(User $user): void;
}