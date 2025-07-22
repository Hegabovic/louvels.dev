<?php
declare(strict_types=1);

namespace App\Controller\V1;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class AuthController extends AbstractController
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly JWTTokenManagerInterface $jwtManager,
        private readonly int $ttl = 3600
    ) {}

    #[Route('/register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        // Check if required fields are present
        $requiredFields = ['email', 'password', 'firstName', 'lastName'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                return $this->json(['error' => "Missing required field: $field"], Response::HTTP_BAD_REQUEST);
            }
        }
        
        // Check if user already exists
        $existingUser = $this->userRepository->findByEmail($data['email']);
        if ($existingUser) {
            return $this->json(['error' => 'User with this email already exists'], Response::HTTP_CONFLICT);
        }
        
        // Create new user
        $user = new User();
        $user->setEmail($data['email']);
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        
        // Hash the password
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $data['password']
        );
        $user->setPassword($hashedPassword);
        
        // Save the user
        $this->userRepository->save($user);
        
        // Generate JWT token
        $token = $this->jwtManager->create($user);
        $refreshToken = $token;
        $expiresAt = (new \DateTime())->add(new \DateInterval('PT' . $this->ttl . 'S'))->format('c');
        
        return $this->json([
            'token' => $token,
            'refresh_token' => $refreshToken,
            'user' => [
                'uuid' => $user->getUuid()->toRfc4122(),
                'email' => $user->getEmail(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'roles' => $user->getRoles(),
            ],
            'expires_at' => $expiresAt
        ], Response::HTTP_CREATED);
    }

    #[Route('/login', methods: ['POST'])]
    public function login(): JsonResponse
    {
        // This route is handled by the security system
        // The actual authentication is done by the JSON login authenticator
        // If we reach this method, it means authentication failed
        return $this->json(['error' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
    }

    #[Route('/logout', methods: ['POST'])]
    public function logout(#[CurrentUser] ?User $user): JsonResponse
    {
        // Since JWT is stateless, we don't need to do anything server-side for logout
        // The client should simply discard the token
        // We can still validate that the user is authenticated
        if (!$user) {
            return $this->json(['error' => 'Not authenticated'], Response::HTTP_UNAUTHORIZED);
        }
        
        return $this->json(['message' => 'Logged out successfully']);
    }

    #[Route('/me', methods: ['GET'])]
    public function me(#[CurrentUser] ?User $user): JsonResponse
    {
        if (!$user) {
            return $this->json(['error' => 'Not authenticated'], Response::HTTP_UNAUTHORIZED);
        }
        
        return $this->json([
            'user' => [
                'uuid' => $user->getUuid()->toRfc4122(),
                'email' => $user->getEmail(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'roles' => $user->getRoles(),
            ]
        ]);
    }
}