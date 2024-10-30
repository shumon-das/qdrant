<?php

namespace App\Tests\Unit\Models\Request\CollectionConfig;

use PHPUnit\Framework\TestCase;
use Qdrant\Models\Request\CollectionConfig\BinaryQuantization;
use Qdrant\Models\Request\CollectionConfig\DisabledQuantization;

class BinaryQuantizationTest extends TestCase
{
    public function testBasic(): void
    {
        $config = new BinaryQuantization();

        self::assertEquals(
            ['binary' => new \stdClass()],
            $config->toArray()
        );
    }

    public function testWIthAlwaysRamTrue(): void
    {
        $config = new BinaryQuantization(true);
        self::assertEquals(
            [
                'binary' => ['always_ram' => true],
            ],
            $config->toArray()
        );
    }

    public function testDisableQuantization(): void
    {
        $config = new DisabledQuantization();

        $this->assertEquals(['Disabled'], $config->toArray());
    }
}
