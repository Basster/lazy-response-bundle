<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Tests\Response\Handler;

use Basster\LazyResponseBundle\Response\Handler\AbstractLazyResponseHandler;
use Basster\LazyResponseBundle\Response\Handler\RedirectResponseHandler;
use Basster\LazyResponseBundle\Response\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class RedirectResponseHandlerTest.
 *
 * @internal
 */
final class RedirectResponseHandlerTest extends AbstractLazyResponseHandlerTest
{
    private $router;

    protected function setUp(): void
    {
        $this->router = $this->prophesize(RouterInterface::class);
        parent::setUp();
    }

    /**
     * @test
     */
    public function generateRouteFromControllerResult(): void
    {
        $routeName = 'homepage';
        $routeParams = [];

        $controllerResult = new RedirectResponse($routeName, $routeParams);
        $event = $this->createViewEvent($controllerResult);

        $this->router->generate($routeName, $routeParams)
            ->shouldBeCalled()
            ->willReturn('http://localhost/')
        ;

        $this->handler->handleLazyResponse($event);
    }

    protected function getHandlerClassName(): string
    {
        return RedirectResponseHandler::class;
    }

    protected function createHandlerSubject(): AbstractLazyResponseHandler
    {
        return new RedirectResponseHandler($this->router->reveal());
    }
}
