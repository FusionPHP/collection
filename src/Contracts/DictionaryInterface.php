<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection\Contracts;

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
     * @return \Fusion\Collection\Contracts\DictionaryInterface
     *
     * @throws \Fusion\Collection\Exceptions\CollectionException
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
     * @return \Fusion\Collection\Contracts\DictionaryInterface
     *
     * @throws \Fusion\Collection\Exceptions\CollectionException
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
     * @throws \Fusion\Collection\Exceptions\CollectionException
     */
    public function find(string $key);
}