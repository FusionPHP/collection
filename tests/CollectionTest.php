<?php
/**
 * Part of the Fusion.Collection utility package.
 *
 * @author Jason L. Walker
 * @license MIT
 */

namespace Fusion\Collection\Tests;

use Fusion\Collection\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{

    /**
     * Test collection instance
     *
     * @var \Fusion\Collection\Contracts\CollectionInterface
     */
    protected $collection;

    /*
     * Setup
     */
    public function setUp()
    {
        $this->collection = new Collection();
    }

    /*
     * Tear down
     */
    public function tearDown()
    {
        $this->collection = null;
    }

    /*
     * Basic collection manipulation tests.
     */

    public function testSetupOnConstruct()
    {
        $this->collection = new Collection([15, "foo", 29, "bar", PHP_INT_MAX]);
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

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testLookForItemOutOfCollectionBounds()
    {
        $this->collection->findAt(30);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testRemoveItemNotInCollectionBounds()
    {
        $this->collection->removeAt(30);
    }

    public function addFooBarBaz()
    {
        $this->collection->add("foo");
        $this->collection->add("bar");
        $this->collection->add("baz");
    }
}