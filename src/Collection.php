<?php

namespace McAskill\Collection;

use Arrayable;
use ArrayIterator;
use CachingIterator;
use Jsonable;
use JsonSerializable;
use Traversable;

/**
 * Collection
 *
 * Note: Adapted from _Slim_ and _Laravel_. See {@see CollectionInterface} for more details.
 */
class Collection implements CollectionInterface, JsonSerializable
{
    /**
     * The items of the collection.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Create new collection.
     *
     * @param mixed $items Pre-populate collection with this key-value array.
     */
    public function __construct($items = [])
    {
        $this->items = $this->getArrayableItems($items);
    }

    /**
     * Retrieve the keys of the items in collection.
     *
     * @return array The collected items' keys.
     */
    public function keys()
    {
        return array_keys($this->items);
    }

    /**
     * Reset the keys on the underlying array.
     *
     * @return self
     */
    public function values()
    {
        $this->items = array_values($this->items);

        return $this;
    }


    // Satisfies CollectionInterface
    // =================================================================================================================

    /**
     * Set an item on the collection.
     *
     * @param  string|null $key   The data key.
     * @param  mixed       $value The data value.
     * @return self
     */
    public function set($key, $value)
    {
        if ($key === null) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }

        return $this;
    }

    /**
     * Add an item to the collection.
     *
     * @param  mixed $value The data value.
     * @return self
     */
    public function add($value)
    {
        $this->items[] = $value;

        return $this;
    }

    /**
     * Retrieve the item by key.
     *
     * @param  string $key     The data key.
     * @param  mixed  $default The default value to return if data key does not exist.
     * @return mixed  The key's value, or the default value.
     */
    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->items[$key] : $this->parseValue($default);
    }

    /**
     * Determine if an item exists in the collection by key.
     *
     * @param  string $key The data key.
     * @return boolean
     */
    public function has($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Add item(s) to collection, merging existing items with the same data key.
     *
     * @param  mixed $items Key-value array of data to merge to this collection.
     * @return self
     */
    public function merge($items)
    {
        $this->items = array_merge($this->items, $this->getArrayableItems($items));

        return $this;
    }

    /**
     * Add item(s) to collection, replacing existing items with the same data key.
     *
     * @param  mixed $items Key-value array of data to replace to this collection.
     * @return self
     */
    public function replace($items)
    {
        $this->items = array_replace($this->items, $this->getArrayableItems($items));

        return $this;
    }

    /**
     * Retrieve all items in collection.
     *
     * @return array The collected items.
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Remove item from collection by key.
     *
     * @param  string $key The data key.
     * @return self
     */
    public function remove($key)
    {
        unset($this->items[$key]);

        return $this;
    }

    /**
     * Remove all items from collection.
     *
     * @return self
     */
    public function clear()
    {
        $this->items = [];

        return $this;
    }



    // Satisfies ArrayAccess
    // =================================================================================================================

    /**
     * Alias of {@see CollectionInterface::has()}.
     *
     * @param  string $key The data key.
     * @return boolean
     */
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * Alias of {@see CollectionInterface::get()}.
     *
     * Get collection item for key
     *
     * @param  string $key     The data key.
     * @return mixed  The key's value.
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Alias of {@see CollectionInterface::set()}.
     *
     * @param  string $key   The data key.
     * @param  mixed  $value The data value.
     * @return void
     */
    public function offsetSet($key, $value)
    {
        if ($key === null) {
            $this->add($value);
        } else {
            $this->set($key, $value);
        }
    }

    /**
     * Alias of {@see CollectionInterface::remove()}.
     *
     * @param  string $key The data key.
     * @return void
     */
    public function offsetUnset($key)
    {
        $this->remove($key);
    }



    // Satisfies Countable
    // =================================================================================================================

    /**
     * Get number of items in collection
     *
     * @return integer
     */
    public function count()
    {
        return count($this->items);
    }



    // Satisfies IteratorAggregate
    // =================================================================================================================

    /**
     * Retrieve an external iterator.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Retrieve a cached iterator.
     *
     * @param  integer $flags Bitmask of flags.
     * @return \CachingIterator
     */
    public function getCachingIterator($flags = CachingIterator::CALL_TOSTRING)
    {
        return new CachingIterator($this->getIterator(), $flags);
    }



    // Satisfies Arrayable
    // =================================================================================================================

    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_map(function ($value) {
            return $value instanceof Arrayable ? $value->toArray() : $value;
        }, $this->items);
    }



    // Satisfies Jsonable
    // =================================================================================================================

    /**
     * Get the collection of items as JSON.
     *
     * @param  integer $options Bitmask of flags.
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }



    // Satisfies JsonSerializable
    // =================================================================================================================

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_map(function ($value) {
            if ($value instanceof JsonSerializable) {
                return $value->jsonSerialize();
            } elseif ($value instanceof Jsonable) {
                return json_decode($value->toJson(), true);
            } elseif ($value instanceof Arrayable) {
                return $value->toArray();
            } else {
                return $value;
            }
        }, $this->items);
    }



    // =================================================================================================================



    /**
     * Process the given value.
     *
     * If the value is callable, it will be called.
     *
     * @param  mixed  $value A value to resolve.
     * @return mixed
     */
    protected function parseValue($value)
    {
        if ($this->useAsCallable($value)) {
            return $value();
        }

        return $value;
    }

    /**
     * Determine if the given value is callable, but not a string.
     *
     * @param  mixed $value A callable value.
     * @return boolean
     */
    protected function useAsCallable($value)
    {
        return ! is_string($value) && is_callable($value);
    }

    /**
     * Get a base collection instance from this collection.
     *
     * @return \McAskill\Collection\Collection
     */
    public function toBase()
    {
        return new self($this);
    }

    /**
     * Convert the collection to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Parse the given items into an array.
     *
     * @param  mixed  $items The variable being parsed.
     * @return array
     */
    protected function getArrayableItems($items)
    {
        if (is_array($items)) {
            return $items;
        } elseif ($items instanceof self) {
            return $items->all();
        } elseif ($items instanceof Arrayable) {
            return $items->toArray();
        } elseif ($items instanceof Jsonable) {
            return json_decode($items->toJson(), true);
        } elseif ($items instanceof JsonSerializable) {
            return $items->jsonSerialize();
        } elseif ($items instanceof Traversable) {
            return iterator_to_array($items);
        }

        return (array) $items;
    }
}
