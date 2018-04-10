<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @author Jason L. Walker
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection\Contracts;

interface CollectionCoreInterface
{
    /**
     * Returns the number of items in the collection.
     *
     * @return int
     */
    public function size(): int;

    /**
     * Clears all items from the collection.
     */
    public function clear(): void;

    public function remove($item): void;

    public function removeAt($key): void;
}