<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Response\Handler;

use Basster\LazyResponseBundle\Response\LazyResponseInterface;
use Basster\LazyResponseBundle\Response\TemplateResponse;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Class TemplateResponseHandler.
 */
final class TwigResponseHandler extends AbstractLazyResponseHandler
{
    /**
     * @var \Twig\Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    protected function isSupported(LazyResponseInterface $controllerResult): bool
    {
        return $controllerResult instanceof TemplateResponse;
    }

    /**
     * @param TemplateResponse $controllerResult
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function generateResponse(LazyResponseInterface $controllerResult): Response
    {
        return new Response($this->twig->render($controllerResult->getTemplate(), $controllerResult->getData()), $controllerResult->getStatus(), $controllerResult->getHeaders());
    }
}
