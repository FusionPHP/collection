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

    public function testAddRemoveItems()
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
        while($this->collection->hasMore())
        {
            $this->collection->removeAt(0);
        }
        $this->assertEquals(0, $this->collection->size());
    }

    public function addFooBarBaz()
    {
        $this->collection->add("foo");
        $this->collection->add("bar");
        $this->collection->add("baz");
    }

    public function testGetLastId()
    {
        $this->addFooBarBaz();
        $this->assertEquals(2, $this->collection->lastId());
    }

    public function testRestrictToType()
    {
        $dummy = new CrashTestDummy();
        $this->collection->addRestriction('\Fusion\Collection\Tests\CrashTestDummy');
        $this->collection->add($dummy);
        $this->collection->add(new CrashTestDummy());
        $this->assertInstanceOf('\Fusion\Collection\Tests\CrashTestDummy',
                                $this->collection->find(1));
        $this->assertEquals($dummy, $this->collection->find(0));
    }

    public function testItemNotPresent()
    {
        $this->collection->add(new CrashTestDummy());
        $this->assertFalse($this->collection->has("foobar"));
    }

    public function testItemNotFound()
    {
        $this->collection->add(new CrashTestDummy());
        $this->assertNull($this->collection->find(6));
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testLookForItemOutOfCollectionBounds()
    {
        $this->collection->strictMode(true);
        $this->collection->add(new CrashTestDummy())->find(30);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testRemoveItemNotInCollectionBounds()
    {
        $this->collection->strictMode(true);
        $this->collection->add(new CrashTestDummy())->removeAt(30);
    }
}