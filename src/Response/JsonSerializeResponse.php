<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Response;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class JsonSerializeResponse.
 */
final class JsonSerializeResponse extends AbstractLazyHttpResponse
{
    /**
     * JsonSerializeResponse constructor.
     */
    public function __construct(private mixed $data, int $status = Response::HTTP_OK, array $headers = [])
    {
        parent::__construct($status, $headers);
    }

    public function getData(): mixed
    {
        return $this->data;
    }
}
