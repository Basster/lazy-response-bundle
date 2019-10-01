<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Response;

/**
 * Marking interface for DTOs which are transfored to responses
 * during kernel.view event.
 */
interface LazyResponseInterface
{
    public function getStatusCode(): int;
}
