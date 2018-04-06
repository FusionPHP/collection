<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 4/6/2018
 * Time: 11:36 AM
 */

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
}