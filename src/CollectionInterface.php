<?php

namespace McAskill\Collection;

/**
 * Collection Interface
 *
 * Note: Adapted from {@link https://github.com/slimphp/Slim Slim}
 * and {@link https://github.com/illuminate/support Illuminate\Support}.
 *
 * @see https://github.com/slimphp/Slim/blob/3.x/LICENSE.md
 * @see https://github.com/laravel/framework/blob/master/LICENSE.md
 */
interface CollectionInterface extends \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * Set collection item.
     *
     * @param  string $key   The data key.
     * @param  mixed  $value The data value.
     * @return void
     */
    public function set($key, $value);

    /**
     * Retrieve the item by key.
     *
     * @param  string $key     The data key.
     * @param  mixed  $default The default value to return if data key does not exist.
     * @return mixed  The key's value, or the default value.
     */
    public function get($key, $default = null);

    /**
     * Determine if an item exists in the collection by key.
     *
     * @param  string $key The data key.
     * @return boolean
     */
    public function has($key);

    /**
     * Add item(s) to collection, merging existing items with the same data key.
     *
     * @param  array|\Traversable $items Key-value array of data to merge to this collection.
     * @return void
     */
    public function merge($items);

    /**
     * Add item(s) to collection, replacing existing items with the same data key.
     *
     * @param  array|\Traversable $items Key-value array of data to replace to this collection.
     * @return void
     */
    public function replace($items);

    /**
     * Retrieve all items in collection.
     *
     * @return array The collection's source data.
     */
    public function all();

    /**
     * Remove item from collection by key.
     *
     * @param  string $key The data key.
     * @return void
     */
    public function remove($key);

    /**
     * Remove all items from collection.
     *
     * @return void
     */
    public function clear();
}
