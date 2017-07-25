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
        parent::__construct($items);
    }

    public function offsetSet($key, $value)
    {
        if (!$this->isValidItem($value)) {
            throw new \TypeError('All items passed to an IssueCollection must by of type Issue');
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
     * @param mixed $item
     * @return bool
     */
    protected function isValidItem(mixed $item): bool
    {
        return ($item instanceof $this->collectionClass);
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