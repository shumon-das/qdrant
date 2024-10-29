<?php

namespace App\Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use Qdrant\Exception\InvalidArgumentException;
use Qdrant\Models\MultiVectorStruct;

class MultiVectorStructTest extends TestCase
{
    public function testMultiVectorStruct(): void
    {
        $vector = new MultiVectorStruct([
            [1, 2, 3], [4, 5, 6],
        ]);
        self::assertEquals([[1, 2, 3], [4, 5, 6]], $vector->toArray());
    }

    public function testNamedMultiVectorStruct(): void
    {
        $vector = new MultiVectorStruct([
            'mono' => [1,2,3],
            'sb' => [1,1,3],
        ]);

        self::assertEquals(
            [
                'mono' => [1,2,3],
                'sb' => [1,1,3],
            ],
            $vector->toArray(),
        );

        self::assertEquals(
            [
                'name' => 'sb',
                'vector' => [1, 1, 3],
            ],
            $vector->toSearchArray('sb'),
        );

        self::assertEquals(
            [
                'name' => 'mono',
                'vector' => [1, 2, 3],
            ],
            $vector->toSearchArray('mono'),
        );
    }

    public function testNamedMultiVectorStructWithMissingName(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Vector with name flow-architect not found');

        $vector = new MultiVectorStruct([
            'mono' => [1,2,3],
            'sb' => [1,1,3],
        ]);

        $vector->toSearchArray('flow-architect');
    }

    public function testMultiVectorStructCount(): void
    {
        $vector = new MultiVectorStruct([
            'mono' => [1,2,3],
            'sb' => [1,1,3],
            'an' => [1,2,4],
        ]);

        self::assertEquals(3, $vector->count());
    }
}
