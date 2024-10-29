<?php

namespace App\Tests\Unit;

use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Qdrant\Response;

class ResponseTest extends TestCase
{
    /**
     * @throws \JsonException
     */
    public function testConstructResponse(): void
    {
        $httpFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $httpResponse = $httpFactory->createResponse(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($streamFactory->createStream(json_encode(['key' => 'value'])));

        $response = new Response($httpResponse);

        self::assertEquals('value', $response['key']);
    }

    /**
     * @throws \JsonException
     */
    public function testConstructResponse2(): void
    {
        $httpFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $httpResponse = $httpFactory->createResponse(200)
            ->withHeader('Content-Type', 'text/html')
            ->withBody($streamFactory->createStream(json_encode(['key' => 'value'])));

        $response = new Response($httpResponse);

        self::assertEquals('{"key":"value"}', $response['content']);
    }

    /**
     * @throws \JsonException
     */
    public function testConstructResponseWith4xxHttpCode(): void
    {
        $httpFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $httpResponse = $httpFactory->createResponse(418)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($streamFactory->createStream(json_encode(['key' => 'value'])));

        $response = new Response($httpResponse);

        self::assertEquals('value', $response['key']);
    }

    /**
     * @throws \JsonException
     */
    public function testConstructResponseWith5xxHttpCode(): void
    {
        $httpFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();

        $httpResponse = $httpFactory->createResponse(510)
            ->withBody($streamFactory->createStream(json_encode(['key' => 'value'])));

        $response = new Response($httpResponse);

        self::assertEquals('{"key":"value"}', $response['content']);
    }
}
