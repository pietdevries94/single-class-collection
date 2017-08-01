<?php declare(strict_types=1);
namespace Pietdevries94\SingleClassCollection;

use Illuminate\Support\Collection;

abstract class AbstractSingleClassCollection extends Collection
{
    /** @var $collectionClass string */
    protected $collectionClass;

    /**
     * AbstractSingleClassCollection constructor.
     * @param array $items
     * @throws \RuntimeException
     * @throws \TypeError
     */
    public function __construct(array $items = [])
    {
        $this->validateCollectionClass();

        if (!$this->areValidItems($items)) {
            throw new \TypeError('All elements in array must be instances of '.$this->collectionClass);
        }

        parent::__construct($items);
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @throws \TypeError
     */
    public function offsetSet($key, $value)
    {
        if (!$this->areValidItems($value)) {
            throw new \TypeError('Value '. (string) $value .' must be an instance of '.$this->collectionClass);
        }
        parent::offsetSet($key, $value);
    }

    /**
     * @param callable $callback
     * @return Collection
     */
    public function mapToCollection(callable $callback): Collection
    {
        return collect($this)->map($callback);
    }

    /**
     * @param array|string $value
     * @param null $key
     * @return Collection
     */
    public function pluck($value, $key = null): Collection
    {
        return collect($this)->pluck($value, $key);
    }

    /**
     * @param array|mixed $itemOrArrayOfItems
     * @return bool
     */
    protected function areValidItems($itemOrArrayOfItems): bool
    {
        if (!$itemOrArrayOfItems)
            return true;

        $array = is_array($itemOrArrayOfItems) ? $itemOrArrayOfItems : [$itemOrArrayOfItems];

        foreach ($array as $item) {
            if (!($item instanceof $this->collectionClass)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @throws \RuntimeException
     */
    private function validateCollectionClass(): void
    {
        if(!class_exists($this->collectionClass)) {
            throw new \RuntimeException('Static property $collectionClass is not implemented');
        }
    }
}