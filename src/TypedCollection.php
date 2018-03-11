<?php
/**
 * Created by PhpStorm.
 * User: Jason Walker
 * Date: 3/10/2018
 * Time: 8:54 PM
 */

namespace Fusion\Collection;


use Fusion\Collection\Contracts\CollectionInterface;

class TypedCollection extends Collection
{
    private $acceptedType;

    public function __construct(string $acceptedType, array $items = [])
    {
        $this->acceptedType = $acceptedType;
        parent::__construct($items);
    }

    public function add($collectable): CollectionInterface
    {
        if (!$collectable instanceof $this->acceptedType)
        {
            throw new \InvalidArgumentException();
        }

        parent::add($collectable);
        return $this;
    }

    public function offsetSet($offset, $value): void
    {
        if (!$value instanceof $this->acceptedType)
        {
            throw new \InvalidArgumentException();
        }

        parent::offsetSet($offset, $value);
    }
}