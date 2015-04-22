<?php
/**
 * Test case class for the Collection Test.
 */

namespace Fusion\Utilities\Collection\Tests;

use Fusion\Utilities\Collection\Collection;

require '../vendor/autoload.php';

class CollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test collection instance
     *
     * @var \Fusion\Utilities\Collection\Collection
     */
    protected $collection;

    //Setup
    public function setUp()
    {
        $this->collection = new Collection();
    }

    //Teardown
    public function tearDown()
    {
        $this->collection = null;
    }

    //Basic collection manipulation tests
    public function testAddItems()
    {
        $this->collection->add("foo");
        $this->collection->add("bar");
        $this->assertEquals(2, $this->collection->size());
    }

    public function testAddRemoveItems()
    {
        $this->collection->add("foo");
        $this->collection->add("bar");
        $this->collection->add("baz");
        $this->assertEquals(3, $this->collection->size());
        $this->collection->remove("bar");
        $this->assertEquals(2, $this->collection->size());
    }

    public function testAddAndEmptyItems()
    {
        $this->collection->add("foo");
        $this->collection->add("bar");
        $this->collection->add("baz");
        $this->assertEquals(3, $this->collection->size());
        while($this->collection->hasMore())
        {
            $this->collection->removeAt(0);
        }
        $this->assertEquals(0, $this->collection->size());
    }


}