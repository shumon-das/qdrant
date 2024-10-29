<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Qdrant\Config;

class ConfigTest extends TestCase
{
    public function testConfig(): void
    {
        $points = new Config('127.0.0.1');
        self::assertEquals('127.0.0.1:6333', $points->getDomain());
    }

    public function testConfigWIthAPiKey(): void
    {
        $points = new Config('127.0.0.1');
        $points->setApiKey('test-api-key');

        self::assertEquals('test-api-key', $points->getApiKey());
    }
}
