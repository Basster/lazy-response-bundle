<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Tests\Response\Handler;

use Basster\LazyResponseBundle\Response\Handler\AbstractLazyResponseHandler;
use Basster\LazyResponseBundle\Response\Handler\TwigResponseHandler;
use Basster\LazyResponseBundle\Response\TemplateResponse;
use Twig\Environment;

/**
 * Class TemplateResponseHandlerTest.
 *
 * @internal
 */
final class TwigResponseHandlerTest extends AbstractLazyResponseHandlerTest
{
    private $twig;

    protected function setUp(): void
    {
        $this->twig = $this->prophesize(Environment::class);
        parent::setUp();
    }

    /**
     * @test
     */
    public function renderTwigTemplateFromControllerResult(): void
    {
        $template = 'homepage.html.twig';
        $data = [];
        $controllerResult = new TemplateResponse($template, $data);
        $event = $this->createViewEvent($controllerResult);

        $this->handler->handleLazyResponse($event);

        $this->twig->render($template, $data)->shouldHaveBeenCalled();
    }

    /**
     * @test
     */
    public function passStatusCodeToResponse(): void
    {
        $created = 201;
        $controllerResult = new TemplateResponse('homepage.html.twig', [], $created);
        $event = $this->createViewEvent($controllerResult);

        $this->handler->handleLazyResponse($event);

        self::assertSame($created, $event->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function passHeadersToResponse(): void
    {
        $headers = ['X-Foo' => 'bar'];
        $controllerResult = new TemplateResponse('homepage.html.twig', [], 200, $headers);
        $event = $this->createViewEvent($controllerResult);

        $this->handler->handleLazyResponse($event);

        self::assertSame($headers['X-Foo'], $event->getResponse()->headers->get('X-Foo'));
    }

    protected function getHandlerClassName(): string
    {
        return TwigResponseHandler::class;
    }

    protected function createHandlerSubject(): AbstractLazyResponseHandler
    {
        return new TwigResponseHandler($this->twig->reveal());
    }
}
