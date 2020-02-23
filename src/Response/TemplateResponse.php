<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Response;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class TemplateResponse.
 */
final class TemplateResponse extends AbstractLazyHttpResponse
{
    /**
     * @var string
     */
    private $template;

    /**
     * @var array
     */
    private $data;

    public function __construct(string $template, array $data = [], int $status = Response::HTTP_OK, array $headers = [])
    {
        parent::__construct($status, $headers);
        $this->template = $template;
        $this->data = $data;
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
