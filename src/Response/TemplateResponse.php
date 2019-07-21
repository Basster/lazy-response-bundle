<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Response;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class TemplateResponse.
 */
final class TemplateResponse implements LazyResponseInterface
{
    /**
     * @var string
     */
    private $template;

    /**
     * @var array
     */
    private $data;

    /**
     * @var int
     */
    private $status;

    /**
     * @var array
     */
    private $headers;

    public function __construct(string $template, array $data, int $status = Response::HTTP_OK, array $headers = [])
    {
        $this->template = $template;
        $this->data = $data;
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

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
