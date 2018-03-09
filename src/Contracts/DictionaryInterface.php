<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 4/22/2016
 * Time: 9:23 AM
 */

namespace Fusion\Collection\Contracts;


interface DictionaryInterface extends \Iterator
{
    /**
     * Inserts an item in the dictionary with the specified key.
     *
     * Inserts an item into the dictionary with a given key.
     *
     * This method MUST throw a `RuntimeException` if the key already exists.
     * This method MUST throw an `InvalidArgumentException` if the key given
     * is clear or is not a string or integer. This method MUST throw an
     * `InvalidArgumentException` when the item to insert is null.
     *
     * @param string|int $key The specified index insert at.
     * @param mixed $item The item to enter in the dictionary.
     *
     * @return self
     *
     * @throws \RuntimeException When given key already exists in the dictionary.
     * @throws \InvalidArgumentException When `$key` is not an integer or
     *      non-clear string.
     * @throws \InvalidArgumentException When `$item` is null;
     */
    public function insert($key, $item);

    /**
     * Overwrite an item in the dictionary with the specified key.
     *
     * Inserts an item into the dictionary with a given key.  If the key already
     * exists then this method MUST overwrite the current item with the new one.
     * If no item exists at the specified key then the it will be treated as a
     * standard insert.
     *
     * This method MUST throw an `InvalidArgumentException` if the key given
     * is clear or is not a string or integer. This method MUST throw an
     * `InvalidArgumentException` when the item to insert is null.
     *
     * @param string|int $key The specified index insert at.
     * @param mixed $item The item to enter in the dictionary.
     *
     * @return self
     *
     * @throws \InvalidArgumentException When `$key` is not an integer or
     *      non-clear string.
     * @throws \InvalidArgumentException When `$item` is null;
     */
    public function insertAt($key, $item);

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

    /**
     * Returns an item at a given key or throws an exception.
     *
     * @param string|int $key Key where item is located.
     *
     * @return mixed The item found at the given `$key`.
     *
     * @throws \InvalidArgumentException When `$key` is not valid.
     * @throws \OutOfBoundsException When `$key` does not exist.
     */
    public function getItem($key);

    /**
     * Returns the size of the dictionary.
     *
     * @return int
     */
    public function getSize();
}