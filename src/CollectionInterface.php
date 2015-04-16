<?php
/**
 * Part of the Fusion.Collection utility package.
 *
 * @author Jason L. Walker
 * @license MIT
 */

namespace Fusion\Utilities\Collection;

/**
 * Defines the interface for a class that can store and traverse a collection of objects.
 */
interface CollectionInterface
{
    /**
     * Adds an object to a collections
     *
     * @param $collectable
     * @return self
     */
    public function add($collectable);

    /**
     * Searches the collection for a particular object and removes it.
     *
     * @param $collectable
     * @return self
     */
    public function remove($collectable);

    /**
     * Checks if a particular object exists.
     *
     * @param $collectable
     * @return bool
     */
    public function has($collectable);

    /**
     * Checks if a particular object exists.
     *
     * Scans the collection for an identical object and returns the object if it exists or null
     * otherwise.
     *
     * @param $collectable
     * @return mixed
     */
    public function find($collectable);

    /**
     * Checks if an object exists at a particular index in the array.
     *
     * Looks in the collection at the specified index, if it exists, and returns the object.  If
     * no object is present or the index does not exist null is returned.
     *
     * @param $id
     * @return mixed
     */
    public function findById($id);

    /**
     * Indicates if a collection has more objects in it. Returns true if so or false otherwise.
     *
     * @return bool
     */
    public function hasMore();
}