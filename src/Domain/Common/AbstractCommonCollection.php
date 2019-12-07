<?php
declare(strict_types=1);

namespace App\Domain\Common;

use App\Domain\Common\Exception\InvalidCollectionItemException;
use App\Domain\Common\Exception\InvalidCollectionTypeException;

/**
 * Class AbstractCommonCollection
 *
 * @package App\Domain\Common
 */
abstract class AbstractCommonCollection implements \IteratorAggregate, \JsonSerializable
{
    /**
     * @var array
     */
    private array $collection = [];

    /**
     * @var string
     */
    private string $collectionType;

    /**
     * @return string
     */
    abstract protected function getCollectionType(): string;

    /**
     * @param array $array
     *
     * @return static
     * @throws InvalidCollectionItemException
     * @throws InvalidCollectionTypeException
     */
    public static function createFromArray(array $array)
    {
        $collection = new static();

        foreach ($array as $value) {
            $collection->addToCollection($value);
        }

        return $collection;
    }

    /**
     * @return \ArrayIterator
     */
    final public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->collection);
    }

    /**
     * @return array
     */
    final public function jsonSerialize(): array
    {
        return $this->collection;
    }

    /**
     * AbstractCommonV2Collection constructor.
     *
     * @throws InvalidCollectionTypeException
     */
    final public function __construct()
    {
        $this->collectionType = $this->getCollectionType();

        if (!is_string($this->collectionType)) {
            throw new InvalidCollectionTypeException(sprintf(
                'CollectionType declared in %s class is not valid. Must use "string" type.',
                static::class
            ));
        }

        if (!class_exists($this->collectionType)
            && !interface_exists($this->collectionType)
        ) {
            throw new InvalidCollectionTypeException(
                "Class/interface \"$this->collectionType\" doesn't exists."
            );
        }
    }

    /**
     * @param mixed $collectionItem
     * @param mixed $key
     *
     * @return $this
     * @throws InvalidCollectionItemException
     */
    final public function addToCollection($collectionItem, $key = null)
    {
        $this->checkIfDoesMatchCollectionType($collectionItem);

        if (is_null($key)) {
            $this->collection[] = $collectionItem;
        } else {
            $this->collection[$key] = $collectionItem;
        }

        return $this;
    }

    /**
     * @param mixed $collectionItem
     *
     * @return bool
     * @throws InvalidCollectionItemException
     */
    final public function removeFromCollection($collectionItem)
    {
        $this->checkIfDoesMatchCollectionType($collectionItem);

        $key = array_search($collectionItem, $this->collection, true);

        if ($key !== false) {
            unset($this->collection[$key]);

            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    final public function isEmpty(): bool
    {
        return empty($this->collection);
    }

    /**
     * @return bool
     */
    final public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * @param mixed $collectionItem
     *
     * @return bool
     * @throws InvalidCollectionItemException
     */
    final public function hasElement($collectionItem): bool
    {
        $this->checkIfDoesMatchCollectionType($collectionItem);

        return in_array($collectionItem, $this->collection);
    }

    /**
     * @param mixed $collectionItem
     *
     * @return bool
     * @throws InvalidCollectionItemException
     */
    final public function hasNotElement($collectionItem): bool
    {
        return !$this->hasElement($collectionItem);
    }

    /**
     * @param \Closure $closure
     * @return $this
     */
    final protected function sort(\Closure $closure)
    {
        usort($this->collection, $closure);

        return $this;
    }

    /**
     * @param mixed $collectionItem
     *
     * @return void
     * @throws InvalidCollectionItemException
     */
    final private function checkIfDoesMatchCollectionType($collectionItem): void
    {
        if (!$collectionItem instanceof $this->collectionType) {
            throw new InvalidCollectionItemException(sprintf(
                "CollectionItem must be typeof %s. Given: %s",
                $this->collectionType,
                is_object($collectionItem)
                    ? get_class($collectionItem) : gettype($collectionItem)
            ));
        }
    }
}
