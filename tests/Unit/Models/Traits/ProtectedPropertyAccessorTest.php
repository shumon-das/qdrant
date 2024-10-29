<?php

namespace App\Tests\Unit\Models\Traits;

use PHPUnit\Framework\TestCase;
//use Qdrant\Exception\InvalidArgumentException;
use InvalidArgumentException;
use Qdrant\Models\Traits\ProtectedPropertyAccessor;

class ProtectedPropertyAccessorTest extends TestCase
{
    public function testAccessProtectedProperty(): void
    {
        $mock = new class {
            use ProtectedPropertyAccessor;
            protected string $proProperty = "example value";
        };

        self::assertEquals('example value', $mock->getProProperty());
    }

    public function testAccessNotExistentProperty(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage("Property 'nonExistentProperty' does not exist");

        $mock = new class {
            use ProtectedPropertyAccessor;
        };

        $a = $mock->getNonExistentProperty();
    }

    public function testAccessPublicProperty(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage("Access to property 'publicProperty' is not allowed");

        $mock = new class {
            use ProtectedPropertyAccessor;

            public string $publicProperty = "example value";
        };

        $mock->getPublicProperty();
    }

    public function testAccessPrivateProperty(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage("Access to property 'privateProperty' is not allowed");

        $mock = new class {
            use ProtectedPropertyAccessor;
            private string $privateProperty = "example value";
        };

        $mock->getPrivateProperty();
    }
}
