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

    /**
     * @return int
     * @deprecated will be removed with version 2.0. use getStatusCode instead.
     */
    public function getStatus(): int
    {
        @trigger_error(
            'Using AbstractLazyHttpResponse::getStatus() is deprecated since version 1.2, use "AbstractLazyHttpResponse::getStatusCode()" instead.',
            E_USER_DEPRECATED
        );

        return $this->getStatusCode();
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
