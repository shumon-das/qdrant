<?php

namespace App\Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use Qdrant\Exception\InvalidArgumentException;
use Qdrant\Models\PointStruct;
use Qdrant\Models\VectorStruct;

class PointStructTest extends TestCase
{
    public function testPointStruct(): void
    {
        $point = new PointStruct(1, new VectorStruct([1, 2, 3]));

        self::assertEquals(
            ['id' => 1, 'vector' => [1, 2, 3]],
            $point->toArray()
        );
    }

    public function testPointStructWithUuid(): void
    {
        $point = new PointStruct('91631794-fb6b-41de-8a83-58c006ec1e5a', new VectorStruct([1, 2, 3]));

        self::assertEquals(
            [
                'id' => '91631794-fb6b-41de-8a83-58c006ec1e5a',
                'vector' => [1, 2, 3],
            ],
            $point->toArray(),
        );
    }

    public function testPointStructWithArray(): void
    {
        $point = PointStruct::createFromArray(['id' => 1, 'vector' => [1, 2, 3]]);

        self::assertEquals(
            ['id' => 1, 'vector' => [1, 2, 3]],
            $point->toArray(),
        );
    }

    public function testPointStructWIthMissingFields(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Missing point keys');

        $point = PointStruct::createFromArray(['id' => 1]);
    }

    public function testPointStructWithWrongObject(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Invalid vector type');
        $class = new class {
            public int $id = 1;
            public array $vector = [1, 2, 3];
        };

        $point = PointStruct::createFromArray([
            'id' => 1,
            'vector' => $class,
        ]);
    }
}
