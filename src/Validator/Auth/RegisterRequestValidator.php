<?php
declare(strict_types=1);

namespace App\Validator\Auth;

use App\Validator\RequestValidatorInterface;
use Symfony\Component\HttpFoundation\Request;

class RegisterRequestValidator implements RequestValidatorInterface
{
    /**
     * @inheritDoc
     */
    public function validate(Request $request): array
    {
        $errors = [];
        $data = json_decode($request->getContent(), true);
        
        // Check if data is valid JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            $errors[] = 'Invalid JSON format';
            return $errors;
        }
        
        // Check if data is provided
        if (!$data) {
            $errors[] = 'No data provided';
            return $errors;
        }
        
        // Check required fields
        if (!isset($data['email']) || empty(trim($data['email']))) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email is not valid';
        }
        
        if (!isset($data['password']) || empty(trim($data['password']))) {
            $errors[] = 'Password is required';
        } elseif (strlen($data['password']) < 6) {
            $errors[] = 'Password must be at least 6 characters long';
        }
        
        if (!isset($data['firstName']) || empty(trim($data['firstName']))) {
            $errors[] = 'First name is required';
        }
        
        if (!isset($data['lastName']) || empty(trim($data['lastName']))) {
            $errors[] = 'Last name is required';
        }
        
        // Validate data types
        if (isset($data['email']) && !is_string($data['email'])) {
            $errors[] = 'Email must be a string';
        }
        
        if (isset($data['password']) && !is_string($data['password'])) {
            $errors[] = 'Password must be a string';
        }
        
        if (isset($data['firstName']) && !is_string($data['firstName'])) {
            $errors[] = 'First name must be a string';
        }
        
        if (isset($data['lastName']) && !is_string($data['lastName'])) {
            $errors[] = 'Last name must be a string';
        }
        
        return $errors;
    }
    
    /**
     * @inheritDoc
     */
    public function supports(Request $request): bool
    {
        return $request->isMethod('POST') && 
               preg_match('#^/api/v1/auth/register$#', $request->getPathInfo());
    }
}