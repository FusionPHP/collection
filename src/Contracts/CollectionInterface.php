<?php
declare(strict_types=1);

/**
 * Part of the Fusion.Collection utility package.
 *
 * @author Jason L. Walker
 * @license MIT
 */

namespace Fusion\Collection\Contracts;

/**
 * Defines the interface for a class that can store and traverse a collection of objects.
 */
interface CollectionInterface
{
    /**
     * Adds an object to a collection.
     *
     * Will throw an InvalidArgumentException if strict mode is on and restrictions are violated.
     *
     * @param mixed $collectable
     * @throws \InvalidArgumentException
     * @return self
     */
    public function add($collectable);

    /**
     * Searches the collection for a particular object and removes it.
     *
     *  Will throw an InvalidArgumentException if strict mode is on and restrictions are violated.
     *
     * @param mixed $collectable
     * @throws \InvalidArgumentException
     * @return self
     */
    public function remove($collectable);

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
    public function removeAt(int $id): CollectionInterface;

    /**
     * Checks if a particular object exists.
     *
     * Iterates over the collections looking for an identical of the item provided.  Returns the
     * index of the item or false if it cannot be found.
     *
     * @param mixed $collectable
     * @return int|bool
     */
    public function has($collectable): bool;

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
    public function find($id);

    /**
     * Gets a count of the items in a collection.
     *
     * @return int
     */
    public function size();
}