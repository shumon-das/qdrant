<?php

namespace App\Tests\Unit\Models\Request;

use PHPUnit\Framework\TestCase;
use Qdrant\Models\Request\Point;
use Qdrant\Models\VectorStruct;

class PointTest extends TestCase
{
    public function testValidBasic(): void
    {
        $point = new Point(
            '1',
            new VectorStruct([1, 2, 3])
        );

        self::assertEquals(
            [
                'id' => 1,
                'vector' => [1, 2, 3],
            ],
            $point->toArray()
        );
    }

    public function testValidBasicWIthArrayVector(): void
    {
        $point = new Point(
            '1',
            [1, 2, 3]
        );
        self::assertEquals(
            [
                'id' => 1,
                'vector' => [1, 2, 3],
            ],
            $point->toArray()
        );
    }

    public function testValidBasicWithPayload(): void
    {
        $point = new Point(
            '1',
            [1, 2, 3],
            ['key' => 'value']
        );

        self::assertEquals(
            [
                'id' => 1,
                'vector' => [1, 2, 3],
                'payload' => ['key' => 'value'],
            ],
            $point->toArray()
        );
    }
}
