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
interface CollectionInterface extends CollectionCoreInterface
{
    /**
     * Adds an item to the collection.
     *
     * @param mixed $collectable
     *
     * @return \Fusion\Collection\Contracts\CollectionInterface
     */
    public function add($value): CollectionInterface;

    public function replace(int $key, $value): CollectionInterface;

    /**
     * Retrieves an item from the collection at the specified index.
     *
     * Looks in the collection at the specified index, if it exists, and returns the item.  Throws
     * an `OutOfBoundsException` if the index doesn't exist.
     *
     * @param int $key
     *
     * @return mixed
     *
     * @throws \OutOfBoundsException If the given `$id` does not exist in the collection.
     */
    public function find(int $key);
}