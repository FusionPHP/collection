<?php

/**
 * Part of the Fusion.Collection package test suite.
 *
 * @license MIT
 */

namespace Fusion\Collection\Tests;

use Fusion\Collection\CollectionFactory;
use Fusion\Collection\Exceptions\CollectionException;
use PHPUnit\Framework\TestCase;

class TypedCollectionTest extends TestCase
{

    public function testSetupTypedCollection(): void
    {
        $starterItems = [
            new CrashTestDummy(),
            new CrashTestDummy(),
            new CrashTestDummy()
        ];

        $collection = CollectionFactory::newTypedCollection(CrashTestDummy::class, $starterItems);

        $expected = 3;
        $this->assertEquals($expected, $collection->count());
    }

    public function testExceptionThrownAddingInvalidType(): void
    {
        $this->expectException(CollectionException::class);
        $collection = CollectionFactory::newTypedCollection(CrashTestDummy::class);
        $collection->add('foo');
    }

    public function testExceptionThrownAddingInvalidTypesDuringSetup(): void
    {
        $this->expectException(CollectionException::class);
        CollectionFactory::newTypedCollection(CrashTestDummy::class, ['foo']);
    }

    public function testExceptionThrownSettingAnOffsetWithAnInvalidType(): void
    {
        $this->expectException(CollectionException::class);
        $collection = CollectionFactory::newTypedCollection(CrashTestDummy::class, [new CrashTestDummy()]);

        $targetOffset = 0;
        $collection[$targetOffset] = 'foo';
    }

    public function testExceptionThrownSettingAnOffsetToNull(): void
    {
        $this->expectException(CollectionException::class);
        $collection = CollectionFactory::newTypedCollection(CrashTestDummy::class, [new CrashTestDummy()]);

        $targetOffset = 0;
        $collection[$targetOffset] = null;
    }

    public function testFullyQualifiedNamesWithLeadingSlashWorks(): void
    {
        $instance = new CrashTestDummy();
        $index = 0;

        $qualifiedName = '\Fusion\Collection\Tests\CrashTestDummy';
        $collection = CollectionFactory::newTypedCollection($qualifiedName, [$instance]);
        $this->assertInstanceOf($qualifiedName, $collection->find($index));
    }

    public function testFullyQualifiedNamesWithoutLeadingSlashWorks(): void
    {
        $instance = new CrashTestDummy();
        $index = 0;

        $qualifiedName = 'Fusion\Collection\Tests\CrashTestDummy';
        $collection = CollectionFactory::newTypedCollection($qualifiedName, [$instance]);
        $this->assertInstanceOf($qualifiedName, $collection->find($index));
    }

    public function testTestSettingNewAcceptedTypeAtOffset(): void
    {
        $thisDummy = new CrashTestDummy();
        $thatDummy = new CrashTestDummy();
        $targetOffset = 0;

        $collection = CollectionFactory::newTypedCollection(CrashTestDummy::class, [$thisDummy]);
        $this->assertSame($thisDummy, $collection[$targetOffset]);

        $collection[$targetOffset] = $thatDummy;
        $this->assertSame($thatDummy, $collection[$targetOffset]);
    }

    public function testExceptionThrownIfStringGivenOnConstructIsEmpty(): void
    {
        $this->expectException(CollectionException::class);
        CollectionFactory::newTypedCollection('');
    }

    public function testExceptionThrownReplacingItemAtOffsetWithNull()
    {
        $this->expectException(CollectionException::class);
        $collection = CollectionFactory::newTypedCollection(CrashTestDummy::class, [new CrashTestDummy()]);
        $collection->replace(0, null);
    }

    public function testExceptionThrownReplacingItemAtOffsetWithIncorrectType()
    {
        $this->expectException(CollectionException::class);
        $collection = CollectionFactory::newTypedCollection(CrashTestDummy::class, [new CrashTestDummy()]);
        $collection->replace(0, new \stdClass());
    }

    public function testReplacingInstance()
    {
        $thisDummy = new CrashTestDummy();
        $thatDummy = new CrashTestDummy();
        $targetOffset = 0;

        $collection = CollectionFactory::newTypedCollection(CrashTestDummy::class, [$thisDummy]);
        $this->assertSame($thisDummy, $collection->find($targetOffset));

        $collection->replace($targetOffset, $thatDummy);
        $this->assertSame($thatDummy, $collection->find($targetOffset));
    }
}
