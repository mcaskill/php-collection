<?php

namespace McAskill\Collection;

use LogicException;

/**
 * Frozen Collection
 *
 * This class behaves the same as {@see ImmutableCollection} except
 * it throws exceptions if mutations are attempted.
 *
 * Note: Adapted from _Slim_ and _Laravel_. See {@see CollectionInterface} for more details.
 */
class FrozenCollection extends Collection
{
    /**
     * Reset the keys on the underlying array.
     *
     * @throws LogicException Attempt to mutate frozen collection.
     * @return void
     */
    public function values()
    {
        throw new LogicException(
            sprintf(
                'Impossible to reset keys on a frozen collection (%s)',
                get_class($this)
            )
        );
    }

    /**
     * Set collection item.
     *
     * @param  string $key   The data key.
     * @param  mixed  $value The data value.
     * @throws LogicException Attempt to mutate frozen collection.
     * @return void
     */
    public function set($key, $value)
    {
        unset($key, $value);

        throw new LogicException(
            sprintf(
                'Impossible to set items on a frozen collection (%s)',
                get_class($this)
            )
        );
    }

    /**
     * Add item(s) to collection, merging existing items with the same data key.
     *
     * @param  mixed $items Key-value array of data to merge to this collection.
     * @throws LogicException Attempt to mutate frozen collection.
     * @return void
     */
    public function merge($items)
    {
        unset($items);

        throw new LogicException(
            sprintf(
                'Impossible to merge items on a frozen collection (%s)',
                get_class($this)
            )
        );
    }

    /**
     * Add item(s) to collection, replacing existing items with the same data key.
     *
     * @param  mixed $items Key-value array of data to replace to this collection.
     * @throws LogicException Attempt to mutate frozen collection.
     * @return void
     */
    public function replace($items)
    {
        unset($items);

        throw new LogicException(
            sprintf(
                'Impossible to replace items on a frozen collection (%s)',
                get_class($this)
            )
        );
    }

    /**
     * Remove item from collection by key.
     *
     * @param  string $key The data key.
     * @throws LogicException Attempt to mutate frozen collection.
     * @return void
     */
    public function remove($key)
    {
        unset($key);

        throw new LogicException(
            sprintf(
                'Impossible to remove an item on a frozen collection (%s)',
                get_class($this)
            )
        );
    }

    /**
     * Remove all items from collection.
     *
     * @throws LogicException Attempt to mutate frozen collection.
     * @return void
     */
    public function clear()
    {
        throw new LogicException(
            sprintf(
                'Impossible to clear a frozen collection (%s)',
                get_class($this)
            )
        );
    }
}
