<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Response;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class JsonSerializeResponse.
 */
final class JsonSerializeResponse extends AbstractLazyHttpResponse
{
    /** @var mixed */
    private $data;

    /**
     * JsonSerializeResponse constructor.
     *
     * @param mixed $data
     * @param int   $status
     * @param array $headers
     */
    public function __construct($data, int $status = Response::HTTP_OK, array $headers = [])
    {
        parent::__construct($status, $headers);
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}
