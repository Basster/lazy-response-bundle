<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Response;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class TemplateResponse.
 */
final class TemplateResponse extends AbstractLazyHttpResponse
{
    public function __construct(private string $template, private array $data = [], int $status = Response::HTTP_OK, array $headers = [])
    {
        parent::__construct($status, $headers);
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
