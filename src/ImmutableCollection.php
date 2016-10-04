<?php

namespace McAskill\Collection;

use LogicException;

/**
 * Immutable Collection
 *
 * This class behaves the same as {@see Collection} except
 * it never modifies itself but returns a new object instead.
 *
 * Note: Adapted from _Slim_ and _Laravel_. See {@see CollectionInterface} for more details.
 */
class ImmutableCollection extends Collection
{
    /**
     * Reset the keys on the underlying array.
     *
     * @return static
     */
    public function values()
    {
        return new static(array_values($this->items));
    }

    /**
     * Set an item on the collection.
     *
     * @param  string $key   The data key.
     * @param  mixed  $value The data value.
     * @return static
     */
    public function set($key, $value)
    {
        $items = $this->items;

        if ($key === null) {
            $items[] = $value;
        } else {
            $items[$key] = $value;
        }

        return new static($items);
    }

    /**
     * Add an item to the collection.
     *
     * @param  mixed $value The data value.
     * @return self
     */
    public function add($value)
    {
        $items   = $this->items;
        $items[] = $value;

        return new static($items);
    }

    /**
     * Add item(s) to collection, merging existing items with the same data key.
     *
     * @param  mixed $items Key-value array of data to merge to this collection.
     * @return static
     */
    public function merge($items)
    {
        return new static(array_merge($this->items, $this->getArrayableItems($items)));
    }

    /**
     * Add item(s) to collection, replacing existing items with the same data key.
     *
     * @param  mixed $items Key-value array of data to replace to this collection.
     * @return static
     */
    public function replace($items)
    {
        return new static(array_replace($this->items, $this->getArrayableItems($items)));
    }

    /**
     * Remove item from collection by key.
     *
     * @param  string $key The data key.
     * @return static
     */
    public function remove($key)
    {
        $items = $this->items;
        unset($items[$key]);

        return new static($items);
    }

    /**
     * Remove all items from collection.
     *
     * @throws LogicException Attempt to mutate immutable collection.
     * @return void
     */
    public function clear()
    {
        throw new LogicException(
            sprintf(
                'Impossible to clear an immutable collection (%s)',
                get_class($this)
            )
        );
    }
}
