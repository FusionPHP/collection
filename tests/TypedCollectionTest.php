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
    private $invalidArgumentExceptionString = '\InvalidArgumentException';

    public function testSetupTypedCollection(): void
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

    public function testExceptionThrownAddingInvalidType(): void
    {
        $this->expectException($this->invalidArgumentExceptionString);
        $collection = new TypedCollection(CrashTestDummy::class);
        $collection->add('foo');
    }

    public function testExceptionThrownAddingInvalidTypesDuringSetup(): void
    {
        $this->expectException($this->invalidArgumentExceptionString);
        new TypedCollection(CrashTestDummy::class, ['foo']);
    }

    public function testExceptionThrownSettingAnOffsetWithAnInvalidType(): void
    {
        $this->expectException($this->invalidArgumentExceptionString);
        $collection = new TypedCollection(CrashTestDummy::class, [new CrashTestDummy()]);

        $targetOffset = 0;
        $collection[$targetOffset] = 'foo';
    }

    public function testExceptionThrownSettingAnOffsetToNull(): void
    {
        $this->expectException($this->invalidArgumentExceptionString);
        $collection = new TypedCollection(CrashTestDummy::class, [new CrashTestDummy()]);

        $targetOffset = 0;
        unset($collection[$targetOffset]);
        $this->assertInstanceOf(CrashTestDummy::class, $collection[$targetOffset]);
    }

    public function testFullyQualifiedNamesWithLeadingSlashWorks(): void
    {
        $instance = new CrashTestDummy();
        $index = 0;

        $qualifiedName = '\Fusion\Collection\Tests\CrashTestDummy';
        $collection = new TypedCollection($qualifiedName, [$instance]);
        $this->assertInstanceOf($qualifiedName, $collection->findAt($index));
    }

    public function testFullyQualifiedNamesWithoutLeadingSlashWorks(): void
    {
        $instance = new CrashTestDummy();
        $index = 0;

        $qualifiedName = 'Fusion\Collection\Tests\CrashTestDummy';
        $collection = new TypedCollection($qualifiedName, [$instance]);
        $this->assertInstanceOf($qualifiedName, $collection->findAt($index));
    }

    public function testTestSettingNewAcceptedTypeAtOffset(): void
    {
        $thisDummy = new CrashTestDummy();
        $thatDummy = new CrashTestDummy();
        $targetOffset = 0;

        $collection = new TypedCollection(CrashTestDummy::class, [$thisDummy]);
        $this->assertSame($thisDummy, $collection[$targetOffset]);

        $collection[$targetOffset] = $thatDummy;
        $this->assertSame($thatDummy, $collection[$targetOffset]);
    }

    public function testExceptionThrownIfStringGivenOnConstructIsEmpty()
    {
        $this->expectException($this->invalidArgumentExceptionString);
        new TypedCollection('');
    }
}
