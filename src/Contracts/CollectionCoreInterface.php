<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection\Contracts;

use Countable;

/**
 * Defines common methods for a collection object.
 *
 * @since 1.0.0
 */
interface CollectionCoreInterface extends Countable
{
    /**
     * Clears all items from the collection.
     *
     * @return void
     */
    public function clear(): void;

    /**
     * Iterates through the collection and removes all values identical to the given item.
     *
     * @param mixed $item
     *
     * @return void
     */
    public function remove($item): void;

    /**
     * Removes an element from the collection at the specified key.
     *
     * @param mixed $key
     *
     * @return void
     */
    public function removeAt($key): void;
}