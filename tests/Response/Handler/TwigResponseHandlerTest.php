<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Tests\Response\Handler;

use Basster\LazyResponseBundle\Response\Handler\AbstractLazyResponseHandler;
use Basster\LazyResponseBundle\Response\Handler\TwigResponseHandler;
use Basster\LazyResponseBundle\Response\TemplateResponse;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Twig\Environment;

/**
 * Class TemplateResponseHandlerTest.
 *
 * @internal
 */
final class TwigResponseHandlerTest extends AbstractLazyResponseHandlerTest
{
    use ProphecyTrait;

    private Environment | ObjectProphecy $twig;

    protected function setUp(): void
    {
        $this->twig = $this->prophesize(Environment::class);
        $this->twig->render(Argument::any(), Argument::cetera())->willReturn('');
        parent::setUp();
    }

    /**
     * @test
     */
    public function renderTwigTemplateFromControllerResult(): void
    {
        $template = 'homepage.html.twig';
        $data = ['foo' => 'bar'];
        $controllerResult = new TemplateResponse($template, $data);

        $this->handleLazyViewResponse($controllerResult);

        $this->twig->render($template, $data)->shouldHaveBeenCalled();
    }

    /**
     * @test
     */
    public function renderTwigTemplateFromControllerResultWithEmptyData(): void
    {
        $template = 'homepage.html.twig';
        $controllerResult = new TemplateResponse($template);

        $this->handleLazyViewResponse($controllerResult);

        $this->twig->render($template, [])->shouldHaveBeenCalled();
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

    private function handleLazyViewResponse(TemplateResponse $controllerResult): void
    {
        $event = $this->createViewEvent($controllerResult);

        $this->handler->handleLazyResponse($event);
    }
}
