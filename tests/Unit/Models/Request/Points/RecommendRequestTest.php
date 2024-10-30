<?php

namespace App\Tests\Unit\Models\Request\Points;

use PHPUnit\Framework\TestCase;
use Qdrant\Exception\InvalidArgumentException;
use Qdrant\Models\Filter\Condition\MatchExcept;
use Qdrant\Models\Filter\Filter;
use Qdrant\Models\Request\Points\RecommendRequest;

class RecommendRequestTest extends TestCase
{
    public function testBasicRecommendRequest(): void
    {
        $request = new RecommendRequest([100, 101], [110]);
        self::assertEquals(
            [
                'positive' => [100, 101],
                'negative' => [110],
            ],
            $request->toArray()
        );
    }

    public function testRecommendRequestWithFilter(): void
    {
        $request = (new RecommendRequest([100, 101], [110]))
            ->setScoreThreshold(1.0)
            ->setOffset(5)
            ->setUsing('using-value')
            ->setFilter(
                (new Filter())->addMust((new MatchExcept('key', ['value'])))
            )
        ;

        self::assertEquals(
            [
                'positive' => [100, 101],
                'negative' => [110],
                'score_threshold' => 1.0,
                'offset' => 5,
                'using' => 'using-value',
                'filter' => [
                    'must' => [
                        [
                            'key' => 'key',
                             'match' => [
                                'except' => ['value']
                            ]
                        ]
                    ]
                ]
            ],
            $request->toArray(),
        );
    }

    public function testRecommendRequestWithInvalidStrategy(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Invalid strategy for recommendation.');
        $request = (new RecommendRequest([100, 101], [110]))
            ->setUsing('using-value')
            ->setStrategy('something');

        self::assertEquals(
            [
                'positive' => [100, 101],
                'negative' => [110],
                'using' => 'something',
            ],
            $request->toArray()
        );
    }

    public function testRecommendRequestWithLimitAndStrategy(): void
    {
        $request = (new RecommendRequest([100, 101], [110]))
            ->setLimit(100)
            ->setStrategy(RecommendRequest::STRATEGY_BEST_SCORE)
            ->setOffset(0)
            ->setShardKey('shard-key')
        ;

        self::assertEquals(
            [
                'positive' => [100, 101],
                'negative' => [110],
                'strategy' => RecommendRequest::STRATEGY_BEST_SCORE,
                'limit' => 100,
                'offset' => 0,
                'shard_key' => 'shard-key',
            ],
            $request->toArray()
        );
    }
}
