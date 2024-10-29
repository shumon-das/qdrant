<?php

namespace App\Tests\Unit\Models\Request;

use PHPUnit\Framework\TestCase;
use Qdrant\Models\Request\CollectionConfig\BinaryQuantization;
use Qdrant\Models\Request\CollectionConfig\CollectionParams;
use Qdrant\Models\Request\CollectionConfig\HnswConfig;
use Qdrant\Models\Request\CollectionConfig\OptimizersConfig;
use Qdrant\Models\Request\UpdateCollection;

class UpdateCollectionTest extends TestCase
{
    public function testUpdateCollectionWithVector(): void
    {
        $collection = new UpdateCollection();
        self::assertEquals([], $collection->toArray());
    }

    public function testUpdateCollectionWithOptimizersConfig(): void
    {
        $collection = new UpdateCollection();
        $collection->setOptimizersConfig(
            (new OptimizersConfig())
            ->setVacuumMinVectorNumber(1)
            ->setDeletedThreshold(1.0)
        );

        self::assertEquals(
            [
                'optimizers_config' => [
                    'deleted_threshold' => 1.0,
                    'vacuum_min_vector_number' => 1
                ]
            ],
            $collection->toArray()
        );
    }

    public function testUpdateCollectionHnswConfig(): void
    {
        $collection = new UpdateCollection();
        $collection->setHnswConfig(
            (new HnswConfig())
            ->setM(1)
            ->setEfConstruct(4)
        );

        self::assertEquals(
            [
                'hnsw_config' => [
                    'm' => 1,
                    'ef_construct' => 4
                ]
            ],
            $collection->toArray()
        );
    }

    public function testUpdateCollectionWIthHnswConfigAndZeroM(): void
    {
        $collection = new UpdateCollection();
        $collection->setHnswConfig(
            (new HnswConfig())
            ->setM(0)
            ->setEfConstruct(4)
        );

        self::assertEquals(
            [
                'hnsw_config' => [
                    'm' => 0,
                    'ef_construct' => 4
                ]
            ],
            $collection->toArray()
        );
    }

    public function testUpdateCollectionWithQuantizationConfig(): void
    {
        $collection = new UpdateCollection();
        $collection->setQuantizationConfig(
            (new BinaryQuantization(true))
        );

        self::assertEquals(
            [
                'quantization_config' => [
                    'binary' => ['always_ram' => true]
                ]
            ],
            $collection->toArray()
        );
    }

    public function testUpdateCollectionWithCollectionParams(): void
    {
        $collection = new UpdateCollection();
        $collection->setCollectionParams(
            (new CollectionParams())->setReplicationFactor(1)
        );

        self::assertEquals(
            [
                'params' => [
                    'replication_factor' => 1,
                ]
            ],
            $collection->toArray()
        );
    }
}
