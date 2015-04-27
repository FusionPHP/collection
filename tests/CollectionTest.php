<?php
/**
 * Test case class for the Collection Test.
 */

namespace Fusion\Utilities\Collection\Tests;

use Fusion\Utilities\Collection\Collection;
use Fusion\Utilities\Collection\Library\Restriction;

require 'vendor/autoload.php';

class CollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test collection instance
     *
     * @var \Fusion\Utilities\Collection\Collection
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
}