<?php

namespace App\Tests\Unit\Models\Request;

use PHPUnit\Framework\TestCase;
use Qdrant\Models\PointStruct;
use Qdrant\Models\Request\PointsBatch;
use Qdrant\Models\VectorStruct;

class PointsBatchTest extends TestCase
{
    public function testValidPointBatch(): void
    {
        $batch = new PointsBatch();

        $batch->addPoint(new PointStruct(
            1,
            new VectorStruct([0.9, 0.2, 0.3], 'image'),
            ['color' => 'red']
        ));

        $batch->addPoint(new PointStruct(
           4,
           new VectorStruct([0.1, 0.5, 0.6], 'name'),
           ['color' => 'blue']
        ));

        $batch->addPoint(new PointStruct(
            3,
            new VectorStruct([0.6, 0.2, 0.3], 'image'),
            ['color' => 'yellow']
        ));

        // @info the comments use for explanation to understand how work PointsBatch test
        self::assertEquals(
            [
                'ids' => [1, 4, 3],
                'vectors' => [
                    'image' => [
                        [0.9, 0.2, 0.3],  // image -> id = 1
                        null,             // name -> id = 4
                        [0.6, 0.2, 0.3]   // image -> id = 3
                    ],
                    'name' => [
                        null,             // image -> id = 1
                        [0.1, 0.5, 0.6],  // name => id = 4
                        null              // image -> id = 3
                    ],
                ],
                'payloads' => [
                    ['color' => 'red'],
                    ['color' => 'blue'],
                    ['color' => 'yellow'],
                ],
            ],
            $batch->toArray()
        );
    }
}
