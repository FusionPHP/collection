<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection\Contracts;

use Fusion\Collection\Exceptions\CollectionException;

/**
 * Defines the interface of the basic functionality for a class that holds a collection of items.
 *
 * @since 1.0.0
 */
interface CollectionInterface extends CollectionCoreInterface
{
    /**
     * Adds a value to the collection.
     *
     * This method will throw a `CollectionException` if the value is `null`.
     *
     * @param mixed $value
     *
     * @return CollectionInterface
     *
     * @throws CollectionException
     */
    public function add($value): CollectionInterface;

    /**
     * Replaces a value in the collection at the given key.
     *
     * This method will throw a `CollectionException` if the value give is `null` or if the key
     * given does not exist in the collection.
     *
     * @param int $key
     * @param mixed $value
     *
     * @return CollectionInterface
     *
     * @throws CollectionException
     */
    public function replace(int $key, $value): CollectionInterface;

    /**
     * Retrieves an item from the collection at the specified key.
     *
     * This method will throw a `CollectionException` if the key given does not exist in the
     * collection.
     *
     * @param int $key
     *
     * @return mixed
     *
     * @throws CollectionException
     */
    public function find(int $key);
}