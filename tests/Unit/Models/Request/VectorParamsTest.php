<?php

namespace App\Tests\Unit\Models\Request;

use PHPUnit\Framework\TestCase;
use Qdrant\Exception\InvalidArgumentException;
use Qdrant\Models\Request\VectorParams;

class VectorParamsTest extends TestCase
{
    public function testInvalidVectorParamsDistance(): void
    {
        self::expectException(InvalidArgumentException::class);
        new VectorParams(300, 'other-distance');
    }

    public function testValidVectorParams(): void
    {
        $vector = new VectorParams(300, VectorParams::DISTANCE_COSINE);
        self::assertEquals(
            ['size' => 300, 'distance' => 'Cosine'],
            $vector->toArray(),
        );
    }
}
