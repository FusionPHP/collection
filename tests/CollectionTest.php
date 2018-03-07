<?php
/**
 * Part of the Fusion.Collection utility package.
 *
 * @author Jason L. Walker
 * @license MIT
 */

namespace Fusion\Collection\Tests;

use Fusion\Collection\Collection;
use Fusion\Collection\Library\Restriction;
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
        $this->collection = new Collection(
            [15, "foo", 29, "bar", PHP_INT_MAX],
            [Restriction::INT, Restriction::STRING]
        );
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

    /*
     * Interrogation tests with restrictions
     */

    public function testRestrictToString()
    {
        $this->collection->addRestriction(Restriction::STRING);
        $this->collection->add("bar");
        $this->assertEquals(0, $this->collection->has("bar"));
    }

    public function testRestrictToInteger()
    {
        $this->collection->addRestriction(Restriction::INT);
        $this->collection->add(42);
        $this->assertEquals(0, $this->collection->has(42));
        $this->assertEquals(42, $this->collection->find(0));
    }

    public function testRestrictToBool()
    {
        $this->collection->addRestriction(Restriction::BOOL);
        $this->collection->add(true);
        $this->collection->add(false);
        $this->assertEquals(1, $this->collection->has(false));
        $this->assertTrue($this->collection->find(0));
    }

    public function testRestrictToFloat()
    {
        $this->collection->addRestriction(Restriction::FLOAT);
        $this->collection->add(182.3330201);
        $this->assertEquals(0, $this->collection->has(182.3330201));
        $this->assertEquals(182.3330201, $this->collection->find(0));
    }

    public function testRestrictToArray()
    {
        $this->collection->addRestriction(Restriction::ARR);
        $array = ["foo", "bar", "baz"];
        $this->collection->add($array);
        $this->assertEquals(0, $this->collection->has($array));
        $this->assertEquals($array, $this->collection->find(0));
    }

    public function testRestrictToObject()
    {
        $this->collection->addRestriction(Restriction::OBJECT);
        $o = new CrashTestDummy();
        $this->collection->add($o);
        $this->assertEquals(0, $this->collection->has($o));
        $this->assertEquals($o, $this->collection->find(0));
    }

    public function testRestrictToCallback()
    {
        $callback = function () { echo "foobar"; };
        $this->collection->addRestriction(Restriction::CALLBACK);
        $this->collection->add(function () {});
        $this->collection->add($callback);
        $this->assertInstanceOf("Closure", $this->collection->find(0));
        $this->assertInternalType("callable", $this->collection->find(1));
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

    public function restrictionValues()
    {
        return
        [
            [Restriction::INT, 50, 50.0, "foobar", false, ['a stands for ' => 'array'], function () {}, new CrashTestDummy()],
            [Restriction::FLOAT, 50, 50.0, "foobar", false, ['a stands for ' => 'array'], function () {}, new CrashTestDummy()],
            [Restriction::STRING, 50, 50.0, "foobar", false, ['a stands for ' => 'array'], function () {}, new CrashTestDummy()],
            [Restriction::BOOL, 50, 50.0, "foobar", false, ['a stands for ' => 'array'], function () {}, new CrashTestDummy()],
            [Restriction::ARR, 50, 50.0, "foobar", false, ['a stands for ' => 'array'], function () {}, new CrashTestDummy()],
            [Restriction::CALLBACK, 50, 50.0, "foobar", false, ['a stands for ' => 'array'], function () {}, new CrashTestDummy()],
            [Restriction::OBJECT, 50, 50.0, "foobar", false, ['a stands for ' => 'array'], function () {}, new CrashTestDummy()],
            ['\Fusion\Collection\Tests\CrashTestDummy', 50, 50.0, "foobar", false, ['a stands for ' => 'array'], function () {}, new CrashTestDummy()]
        ];
    }

    /*
     * Test various failures - no strict mode
     */

    /**
     * @dataProvider restrictionValues
     */
    public function testAddWrongRestrictedType($restriction, $int, $float, $string, $bool, $array, $callback, $object)
    {
        $this->collection->addRestriction($restriction);
        $this->collection->add($int);
        $this->collection->add($float);
        $this->collection->add($string);
        $this->collection->add($bool);
        $this->collection->add($array);
        $this->collection->add($callback);
        $this->collection->add($object);
        $this->assertEquals(1, $this->collection->size());
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

    /*
     * Test various failures - no strict mode
     */

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider restrictionValues
     */
    public function testAddWrongRestrictionTypeWithExceptions($restriction, $int, $float, $string, $bool, $array, $callback, $object)
    {
        $this->collection->strictMode(true);
        $this->collection->addRestriction($restriction)
                         ->add($int)
                         ->add($float)
                         ->add($string)
                         ->add($bool)
                         ->add($array)
                         ->add($callback)
                         ->add($object);
        $this->assertEquals(1, $this->collection->size());
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

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider restrictionValues
     */
    public function testAddRemoveWrongRestrictionTypeWithExceptions($restriction, $int, $float, $string, $bool, $array, $callback, $object)
    {
        $this->collection->strictMode(false);
        $this->collection->add($int)
                         ->add($float)
                         ->add($string)
                         ->add($bool)
                         ->add($array)
                         ->add($callback)
                         ->add($object);
        $this->collection->strictMode(true);
        $this->collection->addRestriction($restriction)
                         ->remove($int)
                         ->remove($float)
                         ->remove($string)
                         ->remove($bool)
                         ->remove($array)
                         ->remove($callback)
                         ->remove($object);
        $this->assertEquals(6, $this->collection->size());
    }
}