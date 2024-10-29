<?php

namespace App\Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use Qdrant\Models\PointsStruct;
use Qdrant\Models\PointStruct;
use Qdrant\Models\VectorStruct;

class PointsStructTest extends TestCase
{
    public function testPointsStruct(): void
    {
        $points = new PointsStruct();
        $points->addPoint(new PointStruct(1, new VectorStruct([1, 2, 3])));

        self::assertEquals(
            [['id' => 1, 'vector' => [1, 2, 3]]],
            $points->toArray(),
        );
    }

    public function testPointsStructWithUuid(): void
    {
        $points = new PointsStruct();
        $points->addPoint(
            new PointStruct(
                '91631794-fb6b-41de-8a83-58c006ec1e5a',
                new VectorStruct([1, 2, 3])
            ),
        );

        self::assertEquals(
            [[
                'id' => '91631794-fb6b-41de-8a83-58c006ec1e5a',
                'vector' => [1, 2, 3],
            ]],
            $points->toArray(),
        );
    }

    public function testAddPointsMethodOfPointsStruct(): void
    {
        $points = new PointsStruct();
        $points->addPoints(
            [
                new PointStruct(
                    '91631794-fb6b-41de-8a83-58c006ec1e5a',
                    new VectorStruct([1, 2, 3]),
                ),
                new PointStruct(
                    '39196c88-cd50-420b-bf8b-8d6dc7b3b12d',
                    new VectorStruct([10, 22, 33]),
                ),
            ]
        );

        self::assertEquals(
            [
                [
                    'id' => '91631794-fb6b-41de-8a83-58c006ec1e5a',
                    'vector' => [1, 2, 3],
                ],
                [
                    'id' => '39196c88-cd50-420b-bf8b-8d6dc7b3b12d',
                    'vector' => [10, 22, 33],
                ],
            ],
            $points->toArray(),
        );
    }

    public function testPointsStructWithArray(): void
    {
        $points = PointsStruct::createFromArray([
            ['id' => 1, 'vector' => [1, 2, 3]],
        ]);

        self::assertEquals(
            [
                ['id' => 1, 'vector' => [1, 2, 3]]
            ],
            $points->toArray()
        );
    }

    public function testPointsStructWithNamedVector(): void
    {
        $points = PointsStruct::createFromArray([
            [
                'id' => 1,
                'vector' => [
                    'id' => 1,
                    'name' => 'mono',
                    'pro' => 'dev',
                    'img' => [1, 5, 9]
                ]
            ],
            [
                'id' => '91631794-fb6b-41de-8a83-58c006ec1e5a',
                'vector' => [
                    'id' => 2,
                    'name' => 'sb',
                    'pro' => 'eng',
                    'image' => [2, 4, 6]
                ]
            ],
        ]);

        self::assertEquals(2, $points->count());
        self::assertEquals(
            [
                [
                    'id' => 1,
                    'vector' => [
                        'id' => 1,
                        'name' => 'mono',
                        'pro' => 'dev',
                        'img' => [1, 5, 9]
                    ]
                ],
                [
                    'id' => '91631794-fb6b-41de-8a83-58c006ec1e5a',
                    'vector' => [
                        'id' => 2,
                        'name' => 'sb',
                        'pro' => 'eng',
                        'image' => [2, 4, 6]
                    ]
                ],
            ],
            $points->toArray(),
        );
    }
}
