Collection
==========

An assortment of specialized arrays.

## Supported Collections

Current implementation:

- `Collection`
- `ImmutableCollection`
- `FrozenCollection`

Planned implementation:

- **Sequences**
  - Keys: Numerical, consequentially increasing, no gaps
  - Values: Anything, duplicates allowed
  - Classes: `Sequence`, `SortedSequence`

- **Maps**
  - Keys: Strings or objects, duplicate keys not allowed
  - Values: Anything, duplicates allowed
  - Classes: `Map`, `ObjectMap`

- **Sets**
  - Keys: Not meaningful
  - Values: Objects, or scalars, each value is guaranteed to be unique (see _Set usage below for details)
  - Classes: `Set`

#### General Characteristics

- Collections are mutable (new elements may be added, existing elements may be modified or removed).
- Immutable and read-only variants are available.
- Equality comparison between elements are always performed using the shallow comparison operator (`===`).
- Sorting algorithms are unstable, that means the order for equal elements is undefined (the default, and only PHP behavior).

## Installation

#### With Composer

```shell
$ composer require mcaskill/collection
```

### Without Composer

Why are you not using [composer](http://getcomposer.org/)? Download this package and import the files you need.

## Acknowledgements

This library is based on the following:

- [Symfony's `ParameterBag`](https://github.com/symfony/dependency-injection)
- [Laravel's `Collection`](https://github.com/illuminate/support)
- [Johannes Schmitt's Collections](https://github.com/schmittjoh/php-collection)
- [Ben Ramsey's Collections](https://github.com/ramsey/collection)
