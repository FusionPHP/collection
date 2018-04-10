<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @author Jason L. Walker
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection\Contracts;

interface DictionaryInterface extends CollectionCoreInterface
{
    public function add(string $key, $value): DictionaryInterface;
    public function replace(string $key, $value): DictionaryInterface;
    public function find(string $key);
}