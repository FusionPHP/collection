<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 4/22/2016
 * Time: 9:23 AM
 */

declare(strict_types=1);

namespace Fusion\Collection\Contracts;


interface DictionaryInterface extends CollectionCoreInterface
{
    public function add(string $key, $value): DictionaryInterface;
    public function replace(string $key, $value): DictionaryInterface;
    public function find(string $key);
}