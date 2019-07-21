<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Tests\Response\Handler;

use Basster\LazyResponseBundle\Response\Handler\AbstractLazyResponseHandler;
use Basster\LazyResponseBundle\Response\Handler\TemplateResponseHandler;
use Basster\LazyResponseBundle\Response\TemplateResponse;
use Twig\Environment;

/**
 * Class TemplateResponseHandlerTest.
 *
 * @internal
 */
final class TemplateResponseHandlerTest extends AbstractLazyResponseHandlerTest
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

    protected function getHandlerClassName(): string
    {
        return TemplateResponseHandler::class;
    }

    protected function createHandlerSubject(): AbstractLazyResponseHandler
    {
        return new TemplateResponseHandler($this->twig->reveal());
    }
}
