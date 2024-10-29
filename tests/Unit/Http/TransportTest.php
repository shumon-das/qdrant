<?php

namespace App\Tests\Unit\Http;


use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Qdrant\Config;
use Qdrant\Http\Transport;

class TransportTest extends TestCase
{
    /**
     * @throws ClientExceptionInterface
     */
    public function testTransportApiKeyHeader(): void
    {
        $client = new Client();
        $config = new Config('127.0.0.1', 3333);
        $config->setApiKey('request-one');
        $transport = new Transport($client, $config);

        $httpFactory = Psr17FactoryDiscovery::findRequestFactory();
        $request = $httpFactory->createRequest('GET', '/');

        self::assertInstanceOf(ResponseInterface::class, $transport->sendRequest($request));
        $lastRequest = $client->getLastRequest();
        self::assertEquals('GET', $lastRequest->getMethod());
        self::assertEquals('request-one', $lastRequest->getHeader('api-key')[0]);
    }
}
