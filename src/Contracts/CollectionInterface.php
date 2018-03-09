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
     * @param mixed $collectable
     *
     * @return self
     */
    public function add($collectable): CollectionInterface;

    /**
     * Searches the collection for an identical item and removes it if found.
     *
     * @param mixed $collectable
     * @return self
     */
    public function remove($collectable): CollectionInterface;

    /**
     * Removes an object at the specified index.
     *
     * Checks for an item at the specified index, if it exists, and removes the item.  Throws an
     * OutOfBoundsException if the index doesn't exist.
     *
     * @param int $id
     * @throws \OutOfBoundsException
     * @return self
     */
    public function removeAt(int $id): CollectionInterface;

    /**
     * Gets an item in the collection at the specified index.
     *
     * Looks in the collection at the specified index, if it exists, and returns the item.  Throws
     * an `OutOfBoundsException` if the index doesn't exist.
     *
     * @param int $id
     * @throws \OutOfBoundsException
     * @return mixed
     */
    public function findAt($id);

    /**
     * Returns the count of the items in a collection.
     *
     * @return int
     */
    public function size(): int;

    /**
     * Clears all items from the collection.
     *
     * @return CollectionInterface
     */
    public function clear(): CollectionInterface;
}