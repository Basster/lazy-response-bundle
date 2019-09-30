<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Tests\Response\Handler;

use Basster\LazyResponseBundle\Response\Handler\AbstractLazyResponseHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Class AbstractLazyResponseHandlerTest.
 */
abstract class AbstractLazyResponseHandlerTest extends TestCase
{
    /** @var AbstractLazyResponseHandler */
    protected $handler;

    protected function setUp(): void
    {
        $this->handler = $this->createHandlerSubject();
    }

    /**
     * @test
     */
    public function subscribesKernelViewEvent(): void
    {
        $events = $this->getHandlerClassName()::getSubscribedEvents();
        self::assertArrayHasKey('kernel.view', $events);
    }

    /**
     * @test
     */
    public function doNothingOnUnsupportedControllerResult(): void
    {
        $this->expectNotToPerformAssertions();

        $event = $this->createViewEvent(new \stdClass());

        $this->handler->handleLazyResponse($event);
    }

    abstract protected function getHandlerClassName(): string;

    protected function createViewEvent($controllerResult): ViewEvent
    {
        return new ViewEvent(
            $this->createMock(Kernel::class),
            new Request(),
            HttpKernelInterface::MASTER_REQUEST,
            $controllerResult
        );
    }

    abstract protected function createHandlerSubject(): AbstractLazyResponseHandler;
}
