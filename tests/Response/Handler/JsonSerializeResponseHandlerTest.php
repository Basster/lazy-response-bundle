<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Tests\Response\Handler;

use Basster\LazyResponseBundle\Response\Handler\AbstractLazyResponseHandler;
use Basster\LazyResponseBundle\Response\Handler\JsonSerializeResponseHandler;
use Basster\LazyResponseBundle\Response\JsonSerializeResponse;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class JsonSerializeResponseHandlerTest.
 *
 * @internal
 */
final class JsonSerializeResponseHandlerTest extends AbstractLazyResponseHandlerTest
{
    private $serializer;

    protected function setUp(): void
    {
        $this->serializer = $this->prophesize(SerializerInterface::class);
        parent::setUp();
    }

    /**
     * @test
     */
    public function serializeControllerResultDataWhenSupported(): void
    {
        $data = new class() {
        };
        $controllerResult = new JsonSerializeResponse($data);
        $event = $this->createViewEvent($controllerResult);
        $this->handler->handleLazyResponse($event);
        $this->serializer->serialize($data, 'json')->shouldHaveBeenCalled();
    }

    protected function getHandlerClassName(): string
    {
        return JsonSerializeResponseHandler::class;
    }

    protected function createHandlerSubject(): AbstractLazyResponseHandler
    {
        return new JsonSerializeResponseHandler($this->serializer->reveal());
    }
}
