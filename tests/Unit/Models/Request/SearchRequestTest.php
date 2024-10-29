<?php

namespace App\Tests\Unit\Models\Request;

use PHPUnit\Framework\TestCase;
use Qdrant\Models\Filter\Condition\MatchString;
use Qdrant\Models\Filter\Filter;
use Qdrant\Models\Request\SearchRequest;
use Qdrant\Models\VectorStruct;

class SearchRequestTest extends TestCase
{
    public function testSearchRequestWithVector(): void
    {
        $vector = new VectorStruct([0, 100, 12], 'image');
        $searchRequest = new SearchRequest($vector);

        self::assertEquals(
            [
                'vector' => [
                    'name' => 'image',
                    'vector' => [0, 100, 12],
                ]
            ],
            $searchRequest->toArray()
        );
    }

    public function testSearchRequestWithVectorAndLimit(): void
    {
        $vector = new VectorStruct([0, 100, 12], 'image');
        $searchRequest = (new SearchRequest($vector))->setLimit(10);

        self::assertEquals(
            [
                'vector' => [
                    'name' => 'image',
                    'vector' => [0, 100, 12],
                ],
                'limit' => 10,
            ],
            $searchRequest->toArray()
        );
    }

    public function testSearchRequestWithVectorAndLimitAndOffset(): void
    {
        $vector = new VectorStruct([0, 100, 12], 'image');
        $searchRequest = (new SearchRequest($vector))
            ->setLimit(10)
            ->setOffset(10);

        self::assertEquals(
            [
                'vector' => [
                    'name' => 'image',
                    'vector' => [0, 100, 12],
                ],
                'limit' => 10,
                'offset' => 10,
            ],
            $searchRequest->toArray()
        );
    }

    public function testSearchRequestWithPayload(): void
    {
        $vector = new VectorStruct([0, 100, 12], 'image');
        $searchRequest = (new SearchRequest($vector))
            ->setWithPayload(true)
            ->setWithVector(true);

        self::assertEquals(
            [
                'vector' => [
                    'name' => 'image',
                    'vector' => [0, 100, 12],
                ],
                'with_payload' => true,
                'with_vector' => true,
            ],
            $searchRequest->toArray(),
        );
    }

    public function testSearchRequestWithParams(): void
    {
        $vector = new VectorStruct([0, 100, 12], 'image');
        $searchRequest = (new SearchRequest($vector))
            ->setParams([
                'param1' => 'value1',
                'param2' => 'value2',
            ]);

        self::assertEquals(
            [
                'vector' => [
                    'name' => 'image',
                    'vector' => [0, 100, 12],
                ],
                'params' => [
                    'param1' => 'value1',
                    'param2' => 'value2',
                ],
            ],
            $searchRequest->toArray()
        );
    }

    public function testSearchRequestWithFilter(): void
    {
        $vector = new VectorStruct([0, 100, 12], 'image');
        $searchRequest = (new SearchRequest($vector))->setFilter(
            (new Filter())->addMust(
                new MatchString('image', 'example image')
            )
        );

        self::assertEquals(
            [
                'vector' => [
                    'name' => 'image',
                    'vector' => [0, 100, 12],
                ],
                'filter' => [
                    'must' => [
                        [
                            'key' => 'image',
                            'match' => ['value' => 'example image'],
                        ],
                    ]
                ],
            ],
            $searchRequest->toArray()
        );
    }
}
