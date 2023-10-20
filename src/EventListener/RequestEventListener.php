<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

#[AsEventListener(event: RequestEvent::class, method: 'forceJsonResponse')]
class RequestEventListener
{
    public function forceJsonResponse(RequestEvent $event): void
    {
        $request = $event->getRequest();

        // On ajoute le header Accept: application/json
        $request->headers->set('Accept', 'application/json');

        // On ajoute le header Content-Type: application/json
        if ($request->isMethod('POST') || $request->isMethod('PUT')) {
            $request->headers->set('Content-Type', 'application/json');
        }
    }
}