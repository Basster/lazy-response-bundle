<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Tests\Response\Handler;

use Basster\LazyResponseBundle\Response\Handler\AbstractLazyResponseHandler;
use Basster\LazyResponseBundle\Response\Handler\RedirectResponseHandler;
use Basster\LazyResponseBundle\Response\RedirectResponse;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class RedirectResponseHandlerTest.
 *
 * @internal
 */
final class RedirectResponseHandlerTest extends AbstractLazyResponseHandlerTest
{
    use ProphecyTrait;

    private const ROUTE_NAME = 'homepage';
    private const ROUTE_PARAMS = [];

    private ObjectProphecy | RouterInterface $router;

    protected function setUp(): void
    {
        $this->router = $this->prophesize(RouterInterface::class);
        $this->router->generate(self::ROUTE_NAME, self::ROUTE_PARAMS)
            ->willReturn('http://localhost/')
        ;
        parent::setUp();
    }

    /**
     * @test
     */
    public function generateRouteFromControllerResult(): void
    {
        $controllerResult = new RedirectResponse(self::ROUTE_NAME, self::ROUTE_PARAMS);

        $this->router
            ->generate(self::ROUTE_NAME, self::ROUTE_PARAMS)
            ->shouldBeCalled()
        ;

        $event = $this->createViewEvent($controllerResult);
        $this->handler->handleLazyResponse($event);
    }

    /**
     * @test
     */
    public function generateTemporaryRedirect(): void
    {
        $controllerResult = new RedirectResponse(self::ROUTE_NAME, self::ROUTE_PARAMS, true);

        $event = $this->createViewEvent($controllerResult);
        $this->handler->handleLazyResponse($event);

        self::assertSame(Response::HTTP_MOVED_PERMANENTLY, $event->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function passHeadersToRedirectResponse(): void
    {
        $headers = ['X-Foo' => 'bar'];
        $controllerResult = new RedirectResponse(self::ROUTE_NAME, self::ROUTE_PARAMS, false, $headers);

        $event = $this->createViewEvent($controllerResult);
        $this->handler->handleLazyResponse($event);

        self::assertSame($headers['X-Foo'], $event->getResponse()->headers->get('X-Foo'));
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
