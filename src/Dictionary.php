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
use Fusion\Collection\Exceptions\CollectionException;

class Dictionary extends AbstractCollection implements DictionaryInterface
{
    public function __construct(array $items = [])
    {
        foreach ($items as $key => $value)
        {
            $this->add($key, $value);
        }
    }

    public function add(string $key, $value): DictionaryInterface
    {
        $this->throwExceptionIfValueIsNull($value);
        $this->offsetSet($key, $value);
        return $this;
    }

    public function replace(string $key, $value): DictionaryInterface
    {
        $this->throwExceptionIfValueIsNull($value);
        $this->offsetSet($key, $value);
        return $this;
    }

    public function find(string $key)
    {
        $this->throwExceptionIfIdDoesNotExist($key);
        return $this->offsetGet($key);
    }

    protected function throwExceptionIfIdDoesNotExist(string $id): void
    {
        parent::throwExceptionIfOffsetDoesNotExist($id);
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
        parent::throwExceptionIfOffsetDoesNotExist($offset);
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
            throw new CollectionException('Offset to access must be a string.');
        }
    }
}