<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 4/5/2018
 * Time: 9:24 AM
 */

declare(strict_types=1);

namespace Fusion\Collection;


use Fusion\Collection\Contracts\DictionaryInterface;
use Fusion\Collection\Exceptions\CollectionException;

class TypedDictionary extends Dictionary
{
    private $acceptedType;

    public function __construct(string $fqcn, array $items = [])
    {
        if ($fqcn == '')
        {
            $message = sprintf(
                '%s must be initialized with a full qualified class name of the instance type to accept',
                TypedDictionary::class
            );

            throw new CollectionException($message);
        }

        $this->acceptedType = $fqcn;
        parent::__construct($items);
    }

    public function add(string $key, $value): DictionaryInterface
    {
        $this->throwExceptionIfNotAcceptedType($value);
        parent::add($key, $value);
        return $this;
    }

    private function throwExceptionIfNotAcceptedType($value): void
    {
        if ($this->notAcceptedType($value))
        {
            throw new CollectionException('This TypedDictionary instance only accepts objects of type: '. $this->acceptedType);
        }
    }

    private function notAcceptedType($value): bool
    {
        return ($value instanceof $this->acceptedType) == false || $value == null;
    }

    public function offsetSet($offset, $value): void
    {
        $this->throwExceptionIfNotAcceptedType($value);
        parent::offsetSet($offset, $value);
    }
}