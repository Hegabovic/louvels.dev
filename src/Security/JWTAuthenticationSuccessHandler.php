<?php
declare(strict_types=1);

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use App\Entity\User;

class JWTAuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private $jwtManager;
    private $originalSuccessHandler;
    private $ttl;

    public function __construct(
        JWTTokenManagerInterface $jwtManager,
        AuthenticationSuccessHandlerInterface $originalSuccessHandler,
        int $ttl = 3600
    ) {
        $this->jwtManager = $jwtManager;
        $this->originalSuccessHandler = $originalSuccessHandler;
        $this->ttl = $ttl;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): \Symfony\Component\HttpFoundation\Response
    {
        // Get the original response from the LexikJWTAuthenticationBundle
        $response = $this->originalSuccessHandler->onAuthenticationSuccess($request, $token);
        
        // Get the data from the response
        $data = json_decode($response->getContent(), true);
        
        // Get the user
        $user = $token->getUser();
        
        if ($user instanceof User) {
            // Add user information to the response
            $data['user'] = [
                'uuid' => $user->getUuid()->toRfc4122(),
                'email' => $user->getEmail(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'roles' => $user->getRoles(),
            ];
            
            // Add expiry time
            $data['expires_at'] = (new \DateTime())->add(new \DateInterval('PT' . $this->ttl . 'S'))->format('c');
        }
        
        // Update the response content
        $response->setData($data);
        
        return $response;
    }
}