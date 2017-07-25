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
            throw new \TypeError('All elements in array must be instances of '.$collectionClass);
        }

        parent::__construct($items);
    }

    public function offsetSet($key, $value)
    {
        if (!$this->isValidItem($value)) {
            throw new \TypeError('Value must be an instance of '.$collectionClass);
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
     * @param mixed $itemOrArrayOfItems
     * @return bool
     */
    protected function areValidItems(mixed $itemOrArrayOfItems): bool
    {
        $array = is_a($itemOrArrayOfItems) ? $itemOrArrayOfItems : [$itemOrArrayOfItems];

        foreach ($array as $item) {
            if (!($item instanceof $this->collectionClass)) {
                return $false;
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