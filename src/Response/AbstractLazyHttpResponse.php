<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Response;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractHttpResponse.
 */
abstract class AbstractLazyHttpResponse implements LazyResponseInterface
{
    /**
     * AbstractLazyHttpResponse constructor.
     */
    public function __construct(protected int $status = Response::HTTP_OK, protected array $headers = [])
    {
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getStatusCode(): int
    {
        return $this->status;
    }
}
