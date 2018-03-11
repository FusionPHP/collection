<?php

/**
 * Part of the Fusion.Collection test suite.
 *
 * @author Jason L. Walker
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection\Tests;

use Fusion\Collection\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    /**
     * @var \Fusion\Collection\Collection
     */
    protected $collection;

    private $outOfBoundsException = \OutOfBoundsException::class;
    private $invalidArgumentException = \InvalidArgumentException::class;

    public function setUp(): void
    {
        $this->makeEmptyCollection();
        $this->addFooBarBaz();
    }
    public function tearDown(): void
    {
        $this->collection = null;
    }

    private function makeEmptyCollection(): void
    {
        $this->collection = new Collection();
    }

    private function addFooBarBaz(): void
    {
        $this->collection->add('foo');
        $this->collection->add('bar');
        $this->collection->add('baz');
    }

    public function testSetupOnConstruct(): void
    {
        $this->collection = new Collection([15, 'foo', 3.14, [], PHP_INT_MAX, new \stdClass()]);

        $expected = 6;
        $this->assertEquals($expected, $this->collection->size());
    }

    public function testAddItems(): void
    {
        $foo = 'foo';
        $bar = 'bar';
        $baz = 'baz';

        $this->makeEmptyCollection();

        $this->collection
            ->add($foo)
            ->add($bar)
            ->add($baz);

        $expected = 3;
        $this->assertEquals($expected, $this->collection->size());
    }

    public function testRemoveItems(): void
    {
        $expected = 3;
        $this->assertEquals($expected, $this->collection->size());

        $removed = 'bar';
        $this->collection->remove($removed);

        $expected = 2;
        $this->assertEquals($expected, $this->collection->size());
    }

    public function testAddAndEmptyItems(): void
    {
        $expected = 3;
        $this->assertEquals($expected, $this->collection->size());

        while($this->collection->size() > 0)
        {
            $this->collection->removeAt(0);
        }

        $expected = 0;
        $this->assertEquals($expected, $this->collection->size());
    }

    public function testRemoveItemNotInCollectionDoesNothing(): void
    {
        $removed = 'quam';
        $this->collection->remove($removed);

        $expected = 3;
        $this->assertEquals($expected, $this->collection->size());
    }

    public function testFindingItemAtId(): void
    {
        $expected = 'foo';
        $this->collection->add($expected);
        $this->assertEquals($expected, $this->collection->findAt(0));
    }

    public function testExceptionThrowLookingForItemOutOfCollectionBounds(): void
    {
        $this->expectException($this->outOfBoundsException);
        $this->collection->findAt(30);
    }

    public function testExceptionThrownRemovingItemNotInCollectionBounds(): void
    {
        $this->expectException($this->outOfBoundsException);
        $this->collection->removeAt(30);
    }

    public function testAccessCurrentElementPosition(): void
    {
        $expected = 'foo';
        $this->addFooBarBaz();
        $this->assertEquals($expected, $this->collection->current());
    }

    public function testAccessNextElementPosition(): void
    {
        $expected = 'bar';
        $this->addFooBarBaz();
        $this->collection->next();
        $this->assertEquals($expected, $this->collection->current());
    }

    public function testAccessCurrentKey(): void
    {
        $expected = 1;
        $this->addFooBarBaz();
        $this->collection->next();
        $this->assertEquals($expected, $this->collection->key());
    }

    public function testCurrentElementIsValidReturnsTrue(): void
    {
        $this->addFooBarBaz();
        $this->assertTrue($this->collection->valid());
    }

    public function testCurrentElementIsValidReturnsFalse(): void
    {
        $this->makeEmptyCollection();
        $this->assertFalse($this->collection->valid());
    }

    public function testRewindingElementPosition(): void
    {
        $expected = 'bar';
        $this->addFooBarBaz();
        $this->collection->next();
        $this->assertEquals($expected, $this->collection->current());

        $expected = 'foo';
        $this->collection->rewind();
        $this->assertEquals($expected, $this->collection->current());
    }

    public function testExceptionThrownTraversingEmptyCollection(): void
    {
        $this->makeEmptyCollection();
        $this->expectException($this->outOfBoundsException);
        $this->collection->current();
    }

    public function testExceptionThrownMovingToNextElementInEmptyCollection(): void
    {
        $this->makeEmptyCollection();
        $this->expectException($this->outOfBoundsException);
        $this->collection->next();
    }

    public function testExceptionThrownWhenAccessingCurrentKeyOfEmptyCollection(): void
    {
        $this->makeEmptyCollection();
        $this->expectException($this->outOfBoundsException);
        $this->collection->key();
    }

    public function testEmptyingCollection(): void
    {
        $expected = 0;
        $this->collection->clear();
        $this->assertEquals($expected, $this->collection->size());
    }

    public function testOffsetExistsInCollection(): void
    {
        $targetOffset = 2;
        $this->assertTrue(isset($this->collection[$targetOffset]));
    }

    public function testExceptionThrownIfNonIntegerGivenAsOffsetExistsValue(): void
    {
        $this->expectException($this->invalidArgumentException);
        $targetOffset = 'foo';

        $this->collection->offsetExists($targetOffset);
    }

    public function testExceptionThrownIfAccessingOffsetAndCollectionIsEmpty(): void
    {
        $this->expectException($this->outOfBoundsException);
        $this->makeEmptyCollection();
        $targetOffset = 0;

        $this->collection->offsetExists($targetOffset);
    }

    public function testExceptionThrownIfAccessingOffsetThatDoesNotExist(): void
    {
        $this->expectException($this->outOfBoundsException);
        $targetOffset = 3;

        $this->collection[$targetOffset];
    }

    public function testRetrievingOffsetFromCollection(): void
    {
        $expected = 'foo';
        $targetOffset = 0;

        $this->assertEquals($expected, $this->collection[$targetOffset]);
    }

    public function testRetrievingOffsetViaArrayAccessNotation(): void
    {
        $expected = 'bar';
        $targetOffset = 1;

        $this->assertEquals($expected, $this->collection[$targetOffset]);
    }

    public function testExceptionThrownIfNonIntegerGivenAsOffsetGetValue(): void
    {
        $this->expectException($this->invalidArgumentException);
        $targetOffset = 'foo';

        $this->collection->offsetGet($targetOffset);
    }

    public function testExceptionThrownIfGettingOffsetAndCollectionIsEmpty(): void
    {
        $this->expectException($this->outOfBoundsException);
        $this->makeEmptyCollection();
        $targetOffset = 0;

        $this->collection->offsetGet($targetOffset);
    }

    public function testExceptionThrownIfGettingOffsetThatDoesNotExist(): void
    {
        $this->expectException($this->outOfBoundsException);
        $targetOffset = 3;

        $this->collection->offsetGet($targetOffset);
    }

    public function testSettingOffsetValueInCollection(): void
    {
        $expected = 'baz';
        $targetOffset = 2;
        $this->assertEquals($expected, $this->collection[$targetOffset]);

        $expected = 'quam';
        $this->collection[$targetOffset] = $expected;
        $this->assertEquals($expected, $this->collection[$targetOffset]);
    }

    public function testExceptionThrownSettingOffsetValueAndOffsetIsNotAnInteger(): void
    {
        $this->expectException($this->invalidArgumentException);
        $newValue = 'quam';
        $targetOffset = 'qux';

        $this->collection[$targetOffset] = $newValue;
    }

    public function testExceptionThrownSettingOffsetValueWhenCollectionIsEmpty(): void
    {
        $this->expectException($this->outOfBoundsException);
        $this->makeEmptyCollection();
        $newValue = 'quam';
        $targetOffset = 1;

        $this->collection[$targetOffset] = $newValue;
    }

    public function testUnsettingElementAtGivenOffset(): void
    {
        $targetOffset = 2;
        unset($this->collection[$targetOffset]);

        $this->assertNull($this->collection[$targetOffset]);
    }

    public function testExceptionThrownUnsettingGivenOffsetAndOffsetIsNotAnInteger(): void
    {
        $this->expectException($this->invalidArgumentException);
        $targetOffset = 'quam';
        unset($this->collection[$targetOffset]);
    }

    public function testExceptionThrownUnsettingGivenOffsetAndCollectionIsEmpty(): void
    {
        $this->expectException($this->outOfBoundsException);
        $this->makeEmptyCollection();
        $targetOffset = 1;
        unset($this->collection[$targetOffset]);
    }
}