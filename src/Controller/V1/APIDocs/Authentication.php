<?php

namespace App\Controller\V1\APIDocs;

use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Areas;

#[Areas(['default'])]
#[OA\Tag(name: 'Authentication', description: 'Authentication operations')]
class Authentication
{
    #[OA\Post(
        path: '/api/v1/register',
        description: 'Creates a new user account with the provided information',
        summary: 'Register a new user',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password', 'firstName', 'lastName'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'user@example.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password123'),
                    new OA\Property(property: 'firstName', type: 'string', example: 'John'),
                    new OA\Property(property: 'lastName', type: 'string', example: 'Doe')
                ]
            )
        ),
        tags: ['Authentication'],
        responses: [
            new OA\Response(
                response: Response::HTTP_CREATED,
                description: 'User registered successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'token', type: 'string', example: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...'),
                        new OA\Property(property: 'refresh_token', type: 'string', example: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...'),
                        new OA\Property(
                            property: 'user',
                            properties: [
                                new OA\Property(property: 'uuid', type: 'string', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000'),
                                new OA\Property(property: 'email', type: 'string', format: 'email', example: 'user@example.com'),
                                new OA\Property(property: 'firstName', type: 'string', example: 'John'),
                                new OA\Property(property: 'lastName', type: 'string', example: 'Doe'),
                                new OA\Property(
                                    property: 'roles',
                                    type: 'array',
                                    items: new OA\Items(type: 'string', example: 'ROLE_USER')
                                )
                            ],
                            type: 'object'
                        ),
                        new OA\Property(property: 'expires_at', type: 'string', format: 'date-time', example: '2025-07-22T17:11:00+00:00')
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: Response::HTTP_BAD_REQUEST,
                description: 'Missing required field',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'Missing required field: email')
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: Response::HTTP_CONFLICT,
                description: 'User already exists',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'User with this email already exists')
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function register()
    {
        // This is just a placeholder for the OpenAPI documentation
    }

    #[OA\Post(
        path: '/api/v1/login',
        description: 'Authenticates a user and returns a JWT token',
        summary: 'Login to the system',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'user@example.com'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password123')
                ]
            )
        ),
        tags: ['Authentication'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Login successful',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'token', type: 'string', example: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...'),
                        new OA\Property(property: 'refresh_token', type: 'string', example: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...'),
                        new OA\Property(
                            property: 'user',
                            properties: [
                                new OA\Property(property: 'uuid', type: 'string', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000'),
                                new OA\Property(property: 'email', type: 'string', format: 'email', example: 'user@example.com'),
                                new OA\Property(property: 'firstName', type: 'string', example: 'John'),
                                new OA\Property(property: 'lastName', type: 'string', example: 'Doe'),
                                new OA\Property(
                                    property: 'roles',
                                    type: 'array',
                                    items: new OA\Items(type: 'string', example: 'ROLE_USER')
                                )
                            ],
                            type: 'object'
                        ),
                        new OA\Property(property: 'expires_at', type: 'string', format: 'date-time', example: '2025-07-22T17:11:00+00:00')
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: Response::HTTP_UNAUTHORIZED,
                description: 'Invalid credentials',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'Invalid credentials')
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function login()
    {
        // This is just a placeholder for the OpenAPI documentation
    }

    #[OA\Post(
        path: '/api/v1/logout',
        description: 'Logs out the current user. Since JWT is stateless, the client should discard the token.',
        summary: 'Logout from the system',
        security: [['Bearer' => []]],
        tags: ['Authentication'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Logout successful',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Logged out successfully')
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: Response::HTTP_UNAUTHORIZED,
                description: 'Not authenticated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'Not authenticated')
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function logout()
    {
        // This is just a placeholder for the OpenAPI documentation
    }

    #[OA\Get(
        path: '/api/v1/me',
        description: 'Returns information about the currently authenticated user',
        summary: 'Get current user information',
        security: [['Bearer' => []]],
        tags: ['Authentication'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'User information retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'user',
                            properties: [
                                new OA\Property(property: 'uuid', type: 'string', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000'),
                                new OA\Property(property: 'email', type: 'string', format: 'email', example: 'user@example.com'),
                                new OA\Property(property: 'firstName', type: 'string', example: 'John'),
                                new OA\Property(property: 'lastName', type: 'string', example: 'Doe'),
                                new OA\Property(
                                    property: 'roles',
                                    type: 'array',
                                    items: new OA\Items(type: 'string', example: 'ROLE_USER')
                                )
                            ],
                            type: 'object'
                        )
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: Response::HTTP_UNAUTHORIZED,
                description: 'Not authenticated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'Not authenticated')
                    ],
                    type: 'object'
                )
            )
        ]
    )]
    public function me()
    {
        // This is just a placeholder for the OpenAPI documentation
    }
}