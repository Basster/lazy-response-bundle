<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Response;

/**
 * Class JsonSerializeResponse.
 */
final class JsonSerializeResponse implements LazyResponseInterface
{
    /** @var mixed */
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}
