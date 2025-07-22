<?php

namespace App\Controller\V1\APIDocs;

use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Areas;

#[Areas(['default'])]
#[OA\Tag(name: 'Countries', description: 'Country management operations')]
class Countries
{
    #[OA\Get(
        path: '/api/v1/countries/{country}',
        description: 'Returns details of a specific country by UUID or name',
        summary: 'Get a specific country',
        tags: ['Countries'],
        parameters: [
            new OA\Parameter(
                name: 'country',
                description: 'Country UUID or name',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string')
            )
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Country details retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'uuid', type: 'string', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000'),
                        new OA\Property(property: 'name', type: 'string', example: 'United States'),
                        new OA\Property(property: 'region', type: 'string', example: 'Americas'),
                        new OA\Property(property: 'subRegion', type: 'string', example: 'Northern America'),
                        new OA\Property(property: 'demonym', type: 'string', example: 'American'),
                        new OA\Property(property: 'population', type: 'integer', example: 331002651),
                        new OA\Property(property: 'independant', type: 'boolean', example: true),
                        new OA\Property(property: 'flag', type: 'string', example: 'https://restcountries.eu/data/usa.svg'),
                        new OA\Property(property: 'currencyName', type: 'string', example: 'United States dollar'),
                        new OA\Property(property: 'currencySymbol', type: 'string', example: '$')
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: 'Country not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'Country not found')
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function getCountry()
    {
        // This is just a placeholder for the OpenAPI documentation
    }

    #[OA\Get(
        path: '/api/v1/countries',
        description: 'Returns a list of all countries in the system',
        summary: 'Get all countries',
        tags: ['Countries'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'List of countries retrieved successfully',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: 'uuid', type: 'string', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000'),
                            new OA\Property(property: 'name', type: 'string', example: 'United States'),
                            new OA\Property(property: 'region', type: 'string', example: 'Americas'),
                            new OA\Property(property: 'subRegion', type: 'string', example: 'Northern America'),
                            new OA\Property(property: 'demonym', type: 'string', example: 'American'),
                            new OA\Property(property: 'population', type: 'integer', example: 331002651),
                            new OA\Property(property: 'independant', type: 'boolean', example: true),
                            new OA\Property(property: 'flag', type: 'string', example: 'https://restcountries.eu/data/usa.svg'),
                            new OA\Property(property: 'currencyName', type: 'string', example: 'United States dollar'),
                            new OA\Property(property: 'currencySymbol', type: 'string', example: '$')
                        ],
                        type: 'object'
                    )
                )
            )
        ]
    )]
    public function getCountries()
    {
        // This is just a placeholder for the OpenAPI documentation
    }

    #[OA\Post(
        path: '/api/v1/countries',
        description: 'Creates a new country with the provided information',
        summary: 'Add a new country',
        security: [['Bearer' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'New Zealand'),
                    new OA\Property(property: 'region', type: 'string', example: 'Oceania'),
                    new OA\Property(property: 'subRegion', type: 'string', example: 'Australia and New Zealand'),
                    new OA\Property(property: 'demonym', type: 'string', example: 'New Zealander'),
                    new OA\Property(property: 'population', type: 'integer', example: 4917000),
                    new OA\Property(property: 'independant', type: 'boolean', example: true),
                    new OA\Property(property: 'flag', type: 'string', example: 'https://restcountries.eu/data/nzl.svg'),
                    new OA\Property(property: 'currencyName', type: 'string', example: 'New Zealand dollar'),
                    new OA\Property(property: 'currencySymbol', type: 'string', example: '$')
                ]
            )
        ),
        tags: ['Countries'],
        responses: [
            new OA\Response(
                response: Response::HTTP_CREATED,
                description: 'Country created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'uuid', type: 'string', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000'),
                        new OA\Property(property: 'name', type: 'string', example: 'New Zealand'),
                        new OA\Property(property: 'region', type: 'string', example: 'Oceania'),
                        new OA\Property(property: 'subRegion', type: 'string', example: 'Australia and New Zealand'),
                        new OA\Property(property: 'demonym', type: 'string', example: 'New Zealander'),
                        new OA\Property(property: 'population', type: 'integer', example: 4917000),
                        new OA\Property(property: 'independant', type: 'boolean', example: true),
                        new OA\Property(property: 'flag', type: 'string', example: 'https://restcountries.eu/data/nzl.svg'),
                        new OA\Property(property: 'currencyName', type: 'string', example: 'New Zealand dollar'),
                        new OA\Property(property: 'currencySymbol', type: 'string', example: '$')
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: Response::HTTP_CONFLICT,
                description: 'Country already exists',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'Country with this name already exists')
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: Response::HTTP_UNAUTHORIZED,
                description: 'Not authenticated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'JWT Token not found')
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function addCountry()
    {
        // This is just a placeholder for the OpenAPI documentation
    }

    #[OA\Patch(
        path: '/api/v1/countries/{country}',
        description: 'Updates an existing country with the provided information',
        summary: 'Update a country',
        security: [['Bearer' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'New Zealand'),
                    new OA\Property(property: 'region', type: 'string', example: 'Oceania'),
                    new OA\Property(property: 'subRegion', type: 'string', example: 'Australia and New Zealand'),
                    new OA\Property(property: 'demonym', type: 'string', example: 'New Zealander'),
                    new OA\Property(property: 'population', type: 'integer', example: 4917000),
                    new OA\Property(property: 'independant', type: 'boolean', example: true),
                    new OA\Property(property: 'flag', type: 'string', example: 'https://restcountries.eu/data/nzl.svg'),
                    new OA\Property(property: 'currencyName', type: 'string', example: 'New Zealand dollar'),
                    new OA\Property(property: 'currencySymbol', type: 'string', example: '$')
                ]
            )
        ),
        tags: ['Countries'],
        parameters: [
            new OA\Parameter(
                name: 'country',
                description: 'Country UUID or name',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string')
            )
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Country updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Country updated successfully'),
                        new OA\Property(
                            property: 'updated_fields',
                            type: 'array',
                            items: new OA\Items(type: 'string', example: 'name')
                        ),
                        new OA\Property(
                            property: 'data',
                            properties: [
                                new OA\Property(property: 'uuid', type: 'string', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000'),
                                new OA\Property(property: 'name', type: 'string', example: 'New Zealand'),
                                new OA\Property(property: 'region', type: 'string', example: 'Oceania'),
                                new OA\Property(property: 'subRegion', type: 'string', example: 'Australia and New Zealand'),
                                new OA\Property(property: 'demonym', type: 'string', example: 'New Zealander'),
                                new OA\Property(property: 'population', type: 'integer', example: 4917000),
                                new OA\Property(property: 'independant', type: 'boolean', example: true),
                                new OA\Property(property: 'flag', type: 'string', example: 'https://restcountries.eu/data/nzl.svg'),
                                new OA\Property(property: 'currencyName', type: 'string', example: 'New Zealand dollar'),
                                new OA\Property(property: 'currencySymbol', type: 'string', example: '$')
                            ],
                            type: 'object'
                        )
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: 'Country not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'Country not found')
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: Response::HTTP_CONFLICT,
                description: 'Country with this name already exists',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'Country with this name already exists')
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: Response::HTTP_UNAUTHORIZED,
                description: 'Not authenticated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'JWT Token not found')
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function updateCountry()
    {
        // This is just a placeholder for the OpenAPI documentation
    }

    #[OA\Delete(
        path: '/api/v1/countries/{country}',
        description: 'Deletes a country by UUID or name',
        summary: 'Delete a country',
        security: [['Bearer' => []]],
        tags: ['Countries'],
        parameters: [
            new OA\Parameter(
                name: 'country',
                description: 'Country UUID or name',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string')
            )
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_NO_CONTENT,
                description: 'Country deleted successfully'
            ),
            new OA\Response(
                response: Response::HTTP_NOT_FOUND,
                description: 'Country not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'Country not found')
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: Response::HTTP_UNAUTHORIZED,
                description: 'Not authenticated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'JWT Token not found')
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function deleteCountry()
    {
        // This is just a placeholder for the OpenAPI documentation
    }
}