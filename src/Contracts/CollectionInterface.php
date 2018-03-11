<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @author Jason L. Walker
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection\Contracts;

/**
 * Defines the interface of the basic functionality for a class that holds a collection of items.
 */
interface CollectionInterface
{
    /**
     * Adds an item to the collection.
     *
     * @param mixed $collectable
     *
     * @return \Fusion\Collection\Contracts\CollectionInterface
     */
    public function add($collectable): CollectionInterface;

    /**
     * Searches the collection for an identical item and removes it if found.
     *
     * @param mixed $collectable
     *
     * @return \Fusion\Collection\Contracts\CollectionInterface
     */
    public function remove($collectable): CollectionInterface;

    /**
     * Removes an object at the specified index.
     *
     * Checks for an item at the specified index, if it exists, and removes the item.  Throws an
     * `OutOfBoundsException` if the index doesn't exist.
     *
     * @param int $id The target index of the item to remove.
     *
     * @return \Fusion\Collection\Contracts\CollectionInterface
     *
     * @throws \OutOfBoundsException If the given `$id` does not exist in the collection.
     */
    public function removeAt(int $id): CollectionInterface;

    /**
     * Retrieves an item from the collection at the specified index.
     *
     * Looks in the collection at the specified index, if it exists, and returns the item.  Throws
     * an `OutOfBoundsException` if the index doesn't exist.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws \OutOfBoundsException If the given `$id` does not exist in the collection.
     */
    public function findAt($id);

    /**
     * Returns the number of items in the collection.
     *
     * @return int
     */
    public function size(): int;

    /**
     * Clears all items from the collection.
     *
     * @return \Fusion\Collection\Contracts\CollectionInterface
     */
    public function clear(): CollectionInterface;
}