<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Response;

/**
 * Class RedirectResponse.
 */
final class RedirectResponse implements LazyResponseInterface
{
    /**
     * @var string
     */
    private $routeName;

    /**
     * @var array
     */
    private $routeParams;

    /**
     * @var bool
     */
    private $isPermanent;

    /**
     * @var array
     */
    private $headers;

    public function __construct(string $routeName, array $routeParams = [], bool $isPermanent = false, array $headers = [])
    {
        $this->routeName = $routeName;
        $this->routeParams = $routeParams;
        $this->isPermanent = $isPermanent;
        $this->headers = $headers;
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
