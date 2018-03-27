<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 4/22/2016
 * Time: 9:47 AM
 */

declare(strict_types=1);

namespace Fusion\Collection;

use Fusion\Collection\Contracts\AbstractCollection;
use Fusion\Collection\Contracts\DictionaryInterface;
use ArrayAccess;
use Iterator;
use InvalidArgumentException;
use OutOfBoundsException;

class Dictionary extends AbstractCollection implements DictionaryInterface, Iterator, ArrayAccess
{
    public function add(string $key, $value): DictionaryInterface
    {
        if ($value == null)
        {
            throw new InvalidArgumentException('Cannot add null values to the dictionary.');
        }

        $this->collection[$key] = $value;
        return $this;
    }

    public function replace(string $key, $value): DictionaryInterface
    {
        $this->throwExceptionIfValueIsNull($value);
        $this->collection[$key] = $value;
        return $this;
    }

    private function throwExceptionIfValueIsNull($value): void
    {
        if (is_null($value))
        {
            throw new InvalidArgumentException('Collection value cannot be null.');
        }
    }

    public function find(string $key)
    {
        $value = null;

        if ($this->offsetExists($key))
        {
            $value = $this->collection[$key];
        }

        return $value;
    }

    /**
     * @inheritdoc
     */
    public function remove($item)
    {
        $this->validateItem($item);
        $result = false;

        foreach ($this->collection as $key => $value)
        {
            if ($value === $item)
            {
                $result = $this->removeAt($key);
            }
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function removeAt($key)
    {
        $this->validateKey($key);
        $result = false;

        if ($this->keyExists($key))
        {
            unset($this->collection[$key]);
            $result = true;
        }

        return $result;
    }

    public function size(): int
    {
        return count($this->collection);
    }

    /**
     * Checks if an item is valid and returns true if it is or false otherwise.
     *
     * @param mixed $item The item to check.
     *
     * @return bool
     */
    protected function isValidItem($item)
    {
        return ($item !== null) ? true : false;
    }

    /**
     * Checks if a key already exists in the dictionary.
     *
     * @param string|int $key The key to check.
     *
     * @return bool
     */
    protected function keyExists($key)
    {
        return array_key_exists($key, $this->collection);
    }

    /**
     * Validate a key or throw an exception.
     *
     * @param string|int $key The key to validate.
     *
     * @return bool
     *
     * @throws \InvalidArgumentException When `$key` is not an integer or
     *      non-clear string.
     */
    protected function validateKey($key)
    {
        $this->throwExceptionIfOffsetIsNotAString($key);
        return true;
    }

    /**
     * Validate an item value or throw an exception.
     *
     * @param mixed $item The item to validate.
     *
     * @return bool
     *
     * @throws \InvalidArgumentException When `$item` is null;
     */
    protected function validateItem($item)
    {
        if (!$this->isValidItem($item))
        {
            throw new \InvalidArgumentException('Item must be a non-null value.');
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return current($this->collection);
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        return next($this->collection);
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return key($this->collection);
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return key($this->collection) !== null;
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        reset($this->collection);
    }

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
        $this->throwExceptionIfIdDoesNotExist($offset);
        return array_key_exists($offset, $this->collection);
    }

    private function throwExceptionIfIdDoesNotExist(string $id): void
    {
        if ($this->idExists($id) == false)
        {
            throw new OutOfBoundsException("The id '$id' doesn't exist in the collection.");
        }
    }

    private function idExists(string $id): bool
    {
        return array_key_exists($id, $this->collection);
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
        $this->throwExceptionIfIdDoesNotExist($offset);
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
    public function offsetSet($offset, $value)
    {
        $this->throwExceptionIfOffsetIsNotAString($offset);
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
    public function offsetUnset($offset)
    {
        $this->throwExceptionIfOffsetIsNotAString($offset);
        $this->removeAt($offset);
    }

    private function throwExceptionIfOffsetIsNotAString($offset)
    {
        if (is_string($offset) == false)
        {
            throw new InvalidArgumentException('Offset to access must be a string.');
        }
    }
}