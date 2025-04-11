<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class ExceptionListener
{
    #[AsEventListener(event: ExceptionEvent::class)]
    public function onExceptionEvent(ExceptionEvent $event): void
    {
       $exception = $event->getThrowable();

       if ($exception instanceof HttpException) {
           $event->setResponse(new JsonResponse($exception->getMessage()));
       }
    }
}
