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
     * @var int
     */
    protected $status;

    /**
     * @var array
     */
    protected $headers;

    /**
     * AbstractLazyHttpResponse constructor.
     */
    public function __construct(int $status = Response::HTTP_OK, array $headers = [])
    {
        $this->status = $status;
        $this->headers = $headers;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}
