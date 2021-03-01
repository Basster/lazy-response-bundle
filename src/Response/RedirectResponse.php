<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Response;

/**
 * Class RedirectResponse.
 */
final class RedirectResponse implements LazyResponseInterface
{
    public function __construct(private string $routeName, private array $routeParams = [], private bool $isPermanent = false, private array $headers = [])
    {
    }

    public function getRouteName(): string
    {
        return $this->routeName;
    }

    public function getRouteParams(): array
    {
        return $this->routeParams;
    }

    public function getStatusCode(): int
    {
        return $this->isPermanent ? 301 : 302;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}
