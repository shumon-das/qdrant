<?php

namespace App\Tests\Unit\Models\Request\Points;

use PHPUnit\Framework\TestCase;
use Qdrant\Models\Request\Points\BatchRecommendRequest;
use Qdrant\Models\Request\Points\RecommendRequest;

class BatchRecommendRequestTest extends TestCase
{
    public function testBasicRecommendRequest(): void
    {
        $request = new BatchRecommendRequest([
            new RecommendRequest([100, 103], [110]),
            new RecommendRequest([102, 104], [111]),
        ]);

        self::assertEquals(
            [
                'searches' => [
                        [
                        'positive' => [100, 103],
                        'negative' => [110],
                    ],
                    [
                        'positive' => [102, 104],
                        'negative' => [111],
                    ]
                ]
            ],
            $request->toArray()
        );
    }
}
