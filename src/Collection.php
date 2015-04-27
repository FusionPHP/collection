<?php
/**
 * Part of the Fusion.Collection utility package.
 *
 * @author Jason L. Walker
 * @license MIT
 */

namespace Fusion\Utilities\Collection;

use Fusion\Utilities\Collection\Library\CollectionInterface;

/**
 * The basic collection class.
 */
class Collection implements CollectionInterface
{

    /**
     * An array holding all collection items.
     *
     * @var array
     */
    protected $collection = [];

    /**
     * An array of restrictions.
     *
     * @var array
     */
    protected $restrictions = [];

    /**
     * Specifies if strict mode is on.
     *
     * When strict mode is on exceptions are thrown when the collection restrictions are violated.
     * When strict mode is off the class will silently fail at certain operations.
     *
     * @var bool
     */
    protected $strictMode = false;

    /**
     * Constructor.
     *
     * Creates a collection with an optional set of initial starter items and restrictions.
     *
     * @param array $items
     * @param array $restrictions
     */
    public function __construct(array $items = [], array $restrictions = [])
    {
        // TODO: Implement constructor method.
    }

    /**
     * Adds an object to a collection.
     *
     * Will throw an InvalidArgumentException if strict mode is on and restrictions are violated.
     *
     * @param mixed $collectable
     * @throws \InvalidArgumentException
     * @return self
     */
    public function add($collectable)
    {
        // TODO: Implement add() method.
    }

    /**
     * Searches the collection for a particular object and removes it.
     *
     *  Will throw an InvalidArgumentException if strict mode is on and restrictions are violated.
     *
     * @param mixed $collectable
     * @throws \InvalidArgumentException
     * @return self
     */
    public function remove($collectable)
    {
        // TODO: Implement remove() method.
    }

    /**
     * Removes an object at the specified index.
     *
     * Checks for an item at the specified index and removes it if it exists.  Throws an
     * OutOfBoundsException if strict mode is on and the index doesn't exist.
     *
     * @param int $id
     * @throws \OutOfBoundsException
     * @return self
     */
    public function removeAt($id)
    {
        // TODO: Implement removeAt() method.
    }

    /**
     * Checks if a particular object exists.
     *
     * Iterates over the collections looking for an identical of the item provided.  Returns the
     * index of the item or false if it cannot be found.
     *
     * @param mixed $collectable
     * @return int|bool
     */
    public function has($collectable)
    {
        // TODO: Implement has() method.
    }

    /**
     * Indicates if a collection has more items in it.
     *
     * @return bool
     */
    public function hasMore()
    {
        // TODO: Implement hasMore() method.
    }

    /**
     * Gets an item in the collection at the specified index.
     *
     * Looks in the collection at the specified index, if it exists, and returns the item.  If
     * no item is present or the index does not exist null is returned.  Throws an
     * OutOfBoundsException if strict mode is on and the index doesn't exist.
     *
     * @param int $id
     * @throws \OutOfBoundsException
     * @return mixed|null
     */
    public function find($id)
    {
        // TODO: Implement find() method.
    }

    /**
     * Adds a restriction to the collection.
     *
     * Will inform the collection that it will now restrict itself to the type defined.  This
     * method may be invoked multiple times to allow multiple value types to be added to the
     * collection. Restrictions can define scalar and non-scalar PHP types.  When defining specific
     * class types the fully qualified name must be used. E.g.: "\Foo\Bar\Baz"
     *
     * @param string $restriction
     * @return self
     */
    public function addRestriction($restriction)
    {
        // TODO: Implement addRestriction() method.
    }

    /**
     * Enables or disables strict mode.
     *
     * @param bool $mode
     * @return self
     */
    public function strictMode($mode)
    {
        // TODO: Implement strictMode() method.
    }

    /**
     * Gets a count of the items in a collection.
     *
     * @return int
     */
    public function size()
    {
        // TODO: Implement size() method.
    }
}