<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection\Contracts;

use Fusion\Collection\Exceptions\CollectionException;

/**
 * Defines the interface of the basic functionality for a class that holds a dictionary of items.
 *
 * @since 1.0.0
 */
interface DictionaryInterface extends CollectionCoreInterface
{
    /**
     * Adds a value to the collection at the given key offset.
     *
     * This method will throw a `CollectionException` if the value given is `null`.
     *
     * @param string $key
     * @param $value
     *
     * @return DictionaryInterface
     *
     * @throws CollectionException
     */
    public function add(string $key, $value): DictionaryInterface;

    /**
     * Replaces a values in the collection at the given key offset.
     *
     * This method will throw a `CollectionException` if the value given is `null`.
     *
     * @param string $key
     * @param $value
     *
     * @return DictionaryInterface
     *
     * @throws CollectionException
     */
    public function replace(string $key, $value): DictionaryInterface;

    /**
     * Locates a value in the collection at the given key offset.
     *
     * This method will throw a `CollectionException` if the offset does not exist.
     *
     * @param string $key
     *
     * @return mixed
     *
     * @throws CollectionException
     */
    public function find(string $key);
}