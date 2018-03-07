<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 4/22/2016
 * Time: 9:47 AM
 */

namespace Fusion\Collection;

use Fusion\Collection\Contracts\DictionaryInterface;

class Dictionary implements DictionaryInterface
{
    /**
     * Key/Value pairs of all items in the dictionary.
     *
     * Keys MUST be non-empty strings or integers and values MUST NOT be null.
     *
     * @var array
     */
    protected $dictionary = [];

    /**
     * @inheritdoc
     */
    public function insert($key, $item)
    {
        $this->validateKey($key);
        $this->validateItem($item);

        if ($this->keyExists($key))
        {
            throw new \RuntimeException(
                $message =
                    sprintf(
                        'The key: %s already exists in the dictionary. Use insertAt() to overwrite this value.',
                        $key
                    )
            );
        }

        $this->dictionary[$key] = $item;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function insertAt($key, $item)
    {
        $this->validateKey($key);
        $this->validateItem($item);
        $this->dictionary[$key] = $item;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function remove($item)
    {
        $this->validateItem($item);

        foreach ($this->dictionary as $key => $value)
        {
            if ($value === $item)
            {
                $this->removeAt($key);
            }
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function removeAt($key)
    {
        $this->validateKey($key);

        if ($this->keyExists($key))
        {
            unset($this->dictionary[$key]);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getItem($key)
    {
        $this->validateKey($key);

        if (!$this->keyExists($key))
        {
            throw new \OutOfBoundsException(
                sprintf('Item not retrieved. The key: %s does not exist in the dictionary.', $key)
            );
        }

        return $this->dictionary[$key];
    }

    /**
     * @inheritdoc
     */
    public function getSize()
    {
        return count($this->dictionary);
    }

    /**
     * Checks if a key is valid and returns true if it is or false otherwise.
     *
     * @param string|int $key The key to check.
     *
     * @return bool
     */
    protected function isValidKey($key)
    {
        return ((is_string($key) && !empty($key)) || is_int($key)) ? true : false;
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
        return array_key_exists($key, $this->dictionary);
    }

    /**
     * Validate a key or throw an exception.
     *
     * @param string|int $key The key to validate.
     *
     * @return bool
     *
     * @throws \InvalidArgumentException When `$key` is not an integer or
     *      non-empty string.
     */
    protected function validateKey($key)
    {
        if (!$this->isValidKey($key))
        {
            throw new \InvalidArgumentException(
                sprintf(
                    'Key must be a non-empty string or integer. %s given.',
                    is_object($key) ? get_class($key) : gettype($key)
                )
            );
        }

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
        return current($this->dictionary);
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        return next($this->dictionary);
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return key($this->dictionary);
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return key($this->dictionary) !== null;
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        reset($this->dictionary);
    }

}