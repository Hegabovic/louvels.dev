<?php
declare(strict_types=1);

namespace App\EventSubscriber;

use App\Validator\RequestValidatorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestValidatorSubscriber implements EventSubscriberInterface
{
    /**
     * @var RequestValidatorInterface[]
     */
    private array $validators;

    /**
     * @param iterable $validators
     */
    public function __construct(iterable $validators)
    {
        $this->validators = [];
        foreach ($validators as $validator) {
            if ($validator instanceof RequestValidatorInterface) {
                $this->validators[] = $validator;
            }
        }
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 28], // Priority just before controller resolution
        ];
    }

    /**
     * Validates the request before it reaches the controller
     *
     * @param RequestEvent $event
     * @return void
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        
        // Skip validation for non-API routes
        if (!str_starts_with($request->getPathInfo(), '/api/')) {
            return;
        }

        // Find a validator that supports this request
        foreach ($this->validators as $validator) {
            if ($validator->supports($request)) {
                $errors = $validator->validate($request);
                
                if (!empty($errors)) {
                    // Return 422 Unprocessable Entity for validation errors
                    $response = new JsonResponse(
                        ['errors' => $errors],
                        Response::HTTP_UNPROCESSABLE_ENTITY
                    );
                    
                    $event->setResponse($response);
                    return;
                }
                
                // Only use the first matching validator
                break;
            }
        }
    }
}