<?php
declare(strict_types=1);

namespace Basster\LazyResponseBundle\Tests\Response\Handler;

use Basster\LazyResponseBundle\Response\Handler\AbstractLazyResponseHandler;
use Basster\LazyResponseBundle\Response\Handler\JsonSerializeResponseHandler;
use Basster\LazyResponseBundle\Response\JsonSerializeResponse;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class JsonSerializeResponseHandlerTest.
 *
 * @internal
 */
final class JsonSerializeResponseHandlerTest extends AbstractLazyResponseHandlerTest
{
    use ProphecyTrait;

    private SerializerInterface | ObjectProphecy $serializer;

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

    /**
     * @test
     */
    public function passStatusCodeToResponse(): void
    {
        $created = 201;
        $controllerResult = new JsonSerializeResponse([], $created);
        $event = $this->createViewEvent($controllerResult);

        $this->handler->handleLazyResponse($event);

        self::assertSame($created, $event->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function passHeadersToResponse(): void
    {
        $headers = ['X-Foo' => 'bar'];
        $controllerResult = new JsonSerializeResponse([], 200, $headers);
        $event = $this->createViewEvent($controllerResult);

        $this->handler->handleLazyResponse($event);

        self::assertSame($headers['X-Foo'], $event->getResponse()->headers->get('X-Foo'));
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
