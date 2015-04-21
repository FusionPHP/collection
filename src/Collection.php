<?php
/**
 * Part of the Fusion.Collection utility package.
 *
 * @author Jason L. Walker
 * @license MIT
 */

namespace Fusion\Utilities\Collection;

use InvalidArgumentException;
use Fusion\Utilities\Collection\Library\CollectionInterface;

class Collection implements CollectionInterface
{

    /**
     * An array holding all collectable items.
     *
     * @var array
     */
    protected $collectables = [];

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
     */

    /**
     * Adds an object to a collections
     *
     * @param mixed $collectable
     * @return self
     */
    public function add($collectable)
    {
        // TODO: Implement add() method.
    }

    /**
     * Searches the collection for a particular object and removes it.
     *
     * @param mixed $collectable
     * @return self
     */
    public function remove($collectable)
    {
        // TODO: Implement remove() method.
    }

    /**
     * Removes an object at the specified index.
     *
     * Checks for an item at the specified index and removes it if it exists.
     *
     * @param int $id
     * @return self
     */
    public function removeAt($id)
    {
        // TODO: Implement removeAt() method.
    }

    /**
     * Checks if a particular object exists.
     *
     * @param mixed $collectable
     * @return bool
     */
    public function has($collectable)
    {
        // TODO: Implement has() method.
    }

    /**
     * Gets an item in the collection at the specified index.
     *
     * Looks in the collection at the specified index, if it exists, and returns the item.  If
     * no item is present or the index does not exist null is returned.
     *
     * @param int $id
     * @return mixed
     */
    public function find($id)
    {
        // TODO: Implement find() method.
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
}