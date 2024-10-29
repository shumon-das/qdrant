<?php

namespace App\Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use Qdrant\Domain\Assert;

class AssertTest extends TestCase
{
    public function testInvalidAssertKeyNotExists(): void
    {
        self::expectException(\InvalidArgumentException::class);

        $data = ['foo' => 'bar'];

        Assert::keysNotExists($data, ['foo']);
    }

//    public function testValidAssertKeyNotExists(): void
//    {
//        $data = [
//            'foo' => 'bar',
//            'foo2' => 'bar2',
//            'foo3' => 'bar3',
//        ];
//
//        Assert::keysNotExists($data, ['fo']);
//    }

//    public function testInvalidAssertExistsAtLeastOne(): void
//    {
//        self::expectException(\InvalidArgumentException::class);
//
//        $data = [
//            'foo' => 'bar',
//            'bar' => 'baz',
//            'baz' => 'qux',
//        ];
//        Assert::keysExistsAtLeastOne($data, ['foo', 'qux']);
//    }
}
