<?php
declare(strict_types=1);

namespace App\Validator\Country;

use App\Validator\RequestValidatorInterface;
use Symfony\Component\HttpFoundation\Request;

class AddCountryRequestValidator implements RequestValidatorInterface
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
        if (!isset($data['name']) || empty(trim($data['name']))) {
            $errors[] = 'Name is required';
        }
        
        // Validate data types
        if (isset($data['region']) && !is_string($data['region'])) {
            $errors[] = 'Region must be a string';
        }
        
        if (isset($data['subRegion']) && !is_string($data['subRegion'])) {
            $errors[] = 'SubRegion must be a string';
        }
        
        if (isset($data['demonym']) && !is_string($data['demonym'])) {
            $errors[] = 'Demonym must be a string';
        }
        
        if (isset($data['population']) && !is_int($data['population']) && !is_numeric($data['population'])) {
            $errors[] = 'Population must be a number';
        }
        
        if (isset($data['independant']) && !is_bool($data['independant']) && !in_array($data['independant'], [0, 1, '0', '1'], true)) {
            $errors[] = 'Independant must be a boolean value';
        }
        
        if (isset($data['flag']) && !is_string($data['flag'])) {
            $errors[] = 'Flag must be a string';
        }
        
        if (isset($data['currencyName']) && !is_string($data['currencyName'])) {
            $errors[] = 'CurrencyName must be a string';
        }
        
        if (isset($data['currencySymbol']) && !is_string($data['currencySymbol'])) {
            $errors[] = 'CurrencySymbol must be a string';
        }
        
        return $errors;
    }
    
    /**
     * @inheritDoc
     */
    public function supports(Request $request): bool
    {
        return $request->isMethod('POST') && 
               preg_match('#^/api/v1/countries$#', $request->getPathInfo());
    }
}