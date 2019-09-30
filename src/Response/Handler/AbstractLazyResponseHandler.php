<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Response\Handler;

use Basster\LazyResponseBundle\Response\LazyResponseInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class AbstractLazyResponseHandler.
 */
abstract class AbstractLazyResponseHandler implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['handleLazyResponse'],
        ];
    }

    public function handleLazyResponse(ViewEvent $event): void
    {
        $controllerResult = $event->getControllerResult();
        if ($this->isSupportedLazyResponse($controllerResult)) {
            $event->setResponse($this->generateResponse($controllerResult));
        }
    }

    abstract protected function isSupported(LazyResponseInterface $controllerResult): bool;

    abstract protected function generateResponse(LazyResponseInterface $controllerResult): Response;

    /**
     * @param mixed $controllerResult
     *
     * @return bool
     */
    private function isSupportedLazyResponse($controllerResult): bool
    {
        return $controllerResult instanceof LazyResponseInterface && $this->isSupported($controllerResult);
    }
}
