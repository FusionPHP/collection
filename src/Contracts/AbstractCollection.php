<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 3/27/2018
 * Time: 1:26 PM
 */

namespace Fusion\Collection\Contracts;

use Fusion\Collection\Exceptions\CollectionException;
use ArrayAccess;
use Iterator;

class AbstractCollection implements ArrayAccess, Iterator
{
    /** @var array */
    protected $collection = [];

    /**
     * Whether a offset exists
     *
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->collection);
    }

    /**
     * Offset to retrieve
     *
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     *
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->collection[$offset];
    }

    /**
     * Offset to set
     *
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value): void
    {
        $this->throwExceptionIfValueIsNull($value);
        $this->collection[$offset] = $value;
    }

    /**
     * Offset to unset
     *
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset): void
    {
        if ($this->offsetExists($offset))
        {
            $this->removeAt($offset);
        }
    }

    protected function throwExceptionIfValueIsNull($value): void
    {
        if ($value === null)
        {
            throw new CollectionException('Collection operations will not accept null values.');
        }
    }

    /**
     * Returns the current element.
     *
     * @link http://php.net/manual/en/iterator.current.php
     *
     * @return mixed
     *
     * @throws \RuntimeException When the collection is empty.
     */
    public function current()
    {
        return current($this->collection);
    }

    /**
     * Move forward to the next element.
     *
     * @link http://php.net/manual/en/iterator.next.php
     *
     * @throws \RuntimeException When the collection is empty
     */
    public function next(): void
    {
        next($this->collection);
    }

    /**
     * Return the key of the current element.
     *
     * @link http://php.net/manual/en/iterator.key.php
     *
     * @return mixed
     *
     * @throws \RuntimeException When the collection is empty.
     */
    public function key()
    {
        return key($this->collection);
    }

    /**
     * Checks if the current position is valid.
     *
     * @link http://php.net/manual/en/iterator.valid.php
     *
     * @return bool
     */
    public function valid(): bool
    {
        return key($this->collection) !== null;
    }

    /**
     * Rewind the collection's position to the first index.
     *
     * @link http://php.net/manual/en/iterator.rewind.php
     */
    public function rewind(): void
    {
        reset($this->collection);
    }
}