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
use InvalidArgumentException;
use OutOfBoundsException;

class Dictionary extends AbstractCollection implements DictionaryInterface
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

    public function find(string $key)
    {
        $this->throwExceptionIfOffsetDoesNotExist($key);
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
        $this->throwExceptionIfValueIsNull($item);
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
        $result = false;

        if ($this->offsetExists($key))
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

    private function throwExceptionIfOffsetDoesNotExist(string $id): void
    {
        if ($this->offsetExists($id) == false)
        {
            throw new OutOfBoundsException("The id '$id' doesn't exist in the collection.");
        }
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
        $this->checkIfOffsetIsAStringAndExists($offset);
        return parent::offsetGet($offset);
    }

    private function checkIfOffsetIsAStringAndExists($offset)
    {
        $this->throwExceptionIfOffsetIsNotAString($offset);
        $this->throwExceptionIfOffsetDoesNotExist($offset);
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
        $this->throwExceptionIfOffsetIsNotAString($offset);
        parent::offsetSet($offset, $value);
    }

    private function throwExceptionIfOffsetIsNotAString($offset): void
    {
        if (is_string($offset) == false)
        {
            throw new InvalidArgumentException('Offset to access must be a string.');
        }
    }
}