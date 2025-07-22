<?php
declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\HttpFoundation\Request;

interface RequestValidatorInterface
{
    /**
     * Validates a request
     *
     * @param Request $request The request to validate
     * @return array An array of validation errors, empty if no errors
     */
    public function validate(Request $request): array;
    
    /**
     * Checks if this validator supports the given request
     *
     * @param Request $request The request to check
     * @return bool True if this validator supports the request, false otherwise
     */
    public function supports(Request $request): bool;
}