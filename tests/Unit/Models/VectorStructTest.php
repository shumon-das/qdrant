<?php

namespace App\Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use Qdrant\Models\VectorStruct;

class VectorStructTest extends TestCase
{
    public function testVectorStruct(): void
    {
        $vector = new VectorStruct([1, 2, 3]);

        self::assertEquals([1, 2, 3], $vector->toArray());
    }

    public function testNamedVectorStruct(): void
    {
        $vector = new VectorStruct([1, 2, 3], 'vec');

        self::assertEquals('vec', $vector->getName());
        self::assertEquals(['vec' => [1, 2, 3]], $vector->toArray());
        self::assertEquals(
            ['name' => 'vec', 'vector' => [1, 2, 3]],
            $vector->toSearchArray()
        );
    }
}
