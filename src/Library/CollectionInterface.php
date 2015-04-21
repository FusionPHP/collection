<?php
/**
 * Part of the Fusion.Collection utility package.
 *
 * @author Jason L. Walker
 * @license MIT
 */

namespace Fusion\Utilities\Collection\Library;

/**
 * Defines the interface for a class that can store and traverse a collection of objects.
 */
interface CollectionInterface
{
    /**
     * Adds an object to a collections
     *
     * @param mixed $collectable
     * @return self
     */
    public function add($collectable);

    /**
     * Searches the collection for a particular object and removes it.
     *
     * @param mixed $collectable
     * @return self
     */
    public function remove($collectable);

    /**
     * Removes an object at the specified index.
     *
     * Checks for an item at the specified index and removes it if it exists.
     *
     * @param int $id
     * @return self
     */
    public function removeAt($id);

    /**
     * Checks if a particular object exists.
     *
     * @param mixed $collectable
     * @return bool
     */
    public function has($collectable);

    /**
     * Gets an item in the collection at the specified index.
     *
     * Looks in the collection at the specified index, if it exists, and returns the item.  If
     * no item is present or the index does not exist null is returned.
     *
     * @param int $id
     * @return mixed
     */
    public function find($id);

    /**
     * Indicates if a collection has more items in it.
     *
     * @return bool
     */
    public function hasMore();

    /**
     * Adds a restriction to the collection.
     *
     * Will inform the collection that is will now restrict itself to the type defined.  This
     * method may be invoked multiple times to allow multiple value types to be added to the
     * collection.
     *
     * @param string $restriction
     * @return self
     */
    public function addRestriction($restriction);
}