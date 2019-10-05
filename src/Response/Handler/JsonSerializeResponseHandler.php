<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Response\Handler;

use Basster\LazyResponseBundle\Response\JsonSerializeResponse;
use Basster\LazyResponseBundle\Response\LazyResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class JsonSerializeResponseHandler.
 */
final class JsonSerializeResponseHandler extends AbstractLazyResponseHandler
{
    /**
     * @var \Symfony\Component\Serializer\SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param JsonSerializeResponse $controllerResult
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    protected function generateResponse(LazyResponseInterface $controllerResult): Response
    {
        return new JsonResponse(
            $this->serializer->serialize($controllerResult->getData(), 'json'),
            $controllerResult->getStatusCode(),
            $controllerResult->getHeaders(),
        );
    }

    protected function isSupported(LazyResponseInterface $controllerResult): bool
    {
        return $controllerResult instanceof JsonSerializeResponse;
    }
}
