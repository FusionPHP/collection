<?php

/**
 * Part of the Fusion.Collection package test suite.
 *
 * @author Jason L. Walker
 * @license MIT
 */

namespace Fusion\Collection\Tests;

use Fusion\Collection\TypedCollection;
use PHPUnit\Framework\TestCase;

class TypedCollectionTest extends TestCase
{
    public function testSetupTypedCollection()
    {
        $starterItems = [
            new CrashTestDummy(),
            new CrashTestDummy(),
            new CrashTestDummy()
        ];

        $collection = new TypedCollection(CrashTestDummy::class, $starterItems);

        $expected = 3;
        $this->assertEquals($expected, $collection->size());
    }

    public function testExceptionThrownAddingInvalidType()
    {
        $this->expectException('\InvalidArgumentException');
        $collection = new TypedCollection(CrashTestDummy::class);
        $collection->add('foo');
    }

    public function testExceptionThrownAddingInvalidTypesDuringSetup()
    {
        $this->expectException('\InvalidArgumentException');
        new TypedCollection(CrashTestDummy::class, ['foo', 'bar']);
    }

    public function testExceptionThrownSettingAnOffsetWithAnInvalidType()
    {
        $this->expectException('\InvalidArgumentException');
        $collection = new TypedCollection(CrashTestDummy::class, [new CrashTestDummy()]);

        $targetOffset = 0;
        $collection[$targetOffset] = 'foo';
    }

    public function testExceptionThrownSettingAnOffsetToNull()
    {
        $this->expectException('\InvalidArgumentException');
        $collection = new TypedCollection(CrashTestDummy::class, [new CrashTestDummy()]);

        $targetOffset = 0;
        unset($collection[$targetOffset]);
        $this->assertInstanceOf(CrashTestDummy::class, $collection[$targetOffset]);
    }

    public function testFullyQualifiedNamesWithLeadingSlashWorks()
    {
        $instance = new CrashTestDummy();
        $index = 0;

        $fqcn = '\Fusion\Collection\Tests\CrashTestDummy';
        $collection = new TypedCollection($fqcn, [$instance]);
        $this->assertInstanceOf($fqcn, $collection->findAt($index));
    }

    public function testFullyQualifiedNamesWithoutLeadingSlashWorks()
    {
        $instance = new CrashTestDummy();
        $index = 0;

        $fqcn = 'Fusion\Collection\Tests\CrashTestDummy';
        $collection = new TypedCollection($fqcn, [$instance]);
        $this->assertInstanceOf($fqcn, $collection->findAt($index));
    }

    public function testTestSettingNewAcceptedTypeAtOffset()
    {
        $thisDummy = new CrashTestDummy();
        $thatDummy = new CrashTestDummy();
        $targetOffset = 0;

        $collection = new TypedCollection(CrashTestDummy::class, [$thisDummy]);
        $this->assertSame($thisDummy, $collection[$targetOffset]);

        $collection[$targetOffset] = $thatDummy;
        $this->assertSame($thatDummy, $collection[$targetOffset]);
    }
}
