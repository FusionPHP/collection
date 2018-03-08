<?php
/**
 * Part of the Fusion.Collection utility package.
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

    public function setUp()
    {
        $this->collection = new Collection();
    }
    public function tearDown()
    {
        $this->collection = null;
    }

    public function addFooBarBaz()
    {
        $this->collection->add('foo');
        $this->collection->add('bar');
        $this->collection->add('baz');
    }

    public function testSetupOnConstruct()
    {
        $this->collection = new Collection([15, 'foo', 29, 'bar', PHP_INT_MAX]);
        $this->assertEquals(5, $this->collection->size());
    }

    public function testAddItems()
    {
        $this->addFooBarBaz();
        $this->assertEquals(3, $this->collection->size());
    }

    public function testRemoveItems()
    {
        $this->addFooBarBaz();
        $this->assertEquals(3, $this->collection->size());
        $this->collection->remove("bar");
        $this->assertEquals(2, $this->collection->size());
    }

    public function testAddAndEmptyItems()
    {
        $this->addFooBarBaz();
        $this->assertEquals(3, $this->collection->size());

        while($this->collection->size() > 0)
        {
            $this->collection->removeAt(0);
        }

        $this->assertEquals(0, $this->collection->size());
    }

    public function testRemoveItemNotInCollectionDoesNothing()
    {
        $this->addFooBarBaz();
        $this->collection->remove('quam');

        $this->assertEquals(3, $this->collection->size());
    }

    public function testFindingItemAtId()
    {
        $expected = 'foo';
        $this->collection->add($expected);
        $this->assertEquals($expected, $this->collection->findAt(0));
    }

    public function testLookForItemOutOfCollectionBounds()
    {
        $this->expectException('\OutOfBoundsException');
        $this->collection->findAt(30);
    }

    public function testRemoveItemNotInCollectionBounds()
    {
        $this->expectException('\OutOfBoundsException');
        $this->collection->removeAt(30);
    }

    public function testAccessCurrentElementPosition()
    {
        $expected = 'foo';
        $this->addFooBarBaz();
        $this->assertEquals($expected, $this->collection->current());
    }

    public function testAccessNextElementPosition()
    {
        $expected = 'bar';
        $this->addFooBarBaz();
        $this->collection->next();
        $this->assertEquals($expected, $this->collection->current());
    }

    public function testAccessCurrentKey()
    {
        $expected = 1;
        $this->addFooBarBaz();
        $this->collection->next();
        $this->assertEquals($expected, $this->collection->key());
    }

    public function testCurrentElementIsValidReturnsTrue()
    {
        $this->addFooBarBaz();
        $this->assertTrue($this->collection->valid());
    }

    public function testCurrentElementIsValidReturnsFalse()
    {
        $this->assertFalse($this->collection->valid());
    }

    public function testRewindingElementPosition()
    {
        $expected = 'bar';
        $this->addFooBarBaz();
        $this->collection->next();
        $this->assertEquals($expected, $this->collection->current());

        $expected = 'foo';
        $this->collection->rewind();
        $this->assertEquals($expected, $this->collection->current());
    }

    public function testExceptionThrownTraversingEmptyCollection()
    {
        $this->expectException('\OutOfBoundsException');
        $this->collection->current();
    }

    public function testExceptionThrownMovingToNextElementInEmptyCollection()
    {
        $this->expectException('\OutOfBoundsException');
        $this->collection->next();
    }

    public function testExceptionThrownWhenAccessingCurrentKeyOfEmptyCollection()
    {
        $this->expectException('\OutOfBoundsException');
        $this->collection->key();
    }
}