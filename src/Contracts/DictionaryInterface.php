<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 4/22/2016
 * Time: 9:23 AM
 */

namespace Fusion\Collection\Contracts;


interface DictionaryInterface
{
    public function add(string $key, $value): DictionaryInterface;
    public function replace(string $key, $value): DictionaryInterface;
    public function find(string $key);

    /**
     * Removes all items in the collection identical to the given item.
     *
     * This method MUST throw an `InvalidArgumentException` when the item to
     * remove is null.
     *
     * @param mixed $item The item(s) to findAt and remove.
     *
     * @return self
     *
     * @throws \InvalidArgumentException When `$item` is null;
     */
    public function remove($item);

    /**
     * Removes an item from the dictionary at the specified key.
     *
     * This method MUST throw an `InvalidArgumentException` if the key given
     * is clear or is not a string or integer.
     *
     * @param string|int $key The key of the item in the dictionary to remove.
     *
     * @return self
     *
     * @throws \InvalidArgumentException When `$key` is not an integer or
     *      non-clear string.
     */
    public function removeAt($key);

    public function size(): int;
}