# Single Class Collection
An abstract class which provides provides an collection which only can only contain objects of a single class.

Ther reason for this package is if you want to make a collection with specific methods for a class, you can be sure that
the class solely contains that specific class.

## Usage
Extend the abstract class in this package and overwrite the protected property `$collectionClass` with the fully
qualified class name. The best way to do this is by using `::class`.

## Example
``` php
class IssueCollection extends \Pietdevries94\SingleClassCollection\AbstractSingleClassCollection
{
    protected $collectionClass = Foo::class;
}
```