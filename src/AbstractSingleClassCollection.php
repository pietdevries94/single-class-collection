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
        $this->validateClass($items);
        parent::__construct($items);
    }

    /**
     * @param mixed $itemOrArray
     * @throws \TypeError
     */
    protected function validateClass(mixed $itemOrArray): void
    {
        // If not an array, make it an array
        $array = is_array($itemOrArray) ? $itemOrArray : [$itemOrArray];

        foreach ($array as $item) {
            if (!($item instanceof $this->collectionClass)) {
                throw new \TypeError('All items passed to an IssueCollection must by of type Issue');
                // If this error is thrown by a collection function, please implement a solution like $this->map()
            }
        }
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

    /**
     * @param callable $callback
     * @return Collection
     */
    public function map(callable $callback): Collection
    {
        return collect($this)->map($callback);
    }

    /**
     * @param mixed $value
     * @return Collection
     */
    public function push($value): Collection
    {
        $this->validateClass($value);
        return parent::push($value);
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return Collection
     */
    public function put($key, $value): Collection
    {
        $this->validateClass($value);
        return parent::put($key, $value);
    }
}