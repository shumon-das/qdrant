<?php

namespace App\Tests\Unit\Models\Traits;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Qdrant\Endpoints\HttpFactoryTrait;

class HttpFactoryTraitTest extends TestCase
{
    public function testCustomHttpRequestFactory(): void
    {
        $requestFactory = new class implements RequestFactoryInterface {
            public function createRequest(string $method, $uri): RequestInterface
            {}
        };

        $mock = new class {
            use HttpFactoryTrait;
        };
        $mock->setHttpFactory($requestFactory);
        self::assertInstanceOf(get_class($requestFactory), $mock->getHttpFactory());
    }

    public function testHeaders(): void
    {
        $mock = new class {
            use HttpFactoryTrait;

            public function test(string $method, string $uri, array $body = [], array $queryString = []): RequestInterface
            {
                return $this->createRequest($method, $uri . $this->queryBuild($queryString), $body);
            }
        };

        $request = $mock->test('GET', '/api', ['data' => 'test'], ['query' => 'test-query']);

        self::assertEquals('{"data":"test"}', $request->getBody()->getContents());
        self::assertEquals('query=test-query', $request->getUri()->getQuery());
        self::assertEquals('/api', $request->getUri()->getPath());
        self::assertEquals('GET', $request->getMethod());
    }
}
