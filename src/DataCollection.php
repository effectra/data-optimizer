<?php

declare(strict_types=1);

namespace Effectra\DataOptimizer;

use ArrayIterator;
use Closure;
use Traversable;

/**
 * Class DataCollection
 * A collection class providing various methods to manipulate and interact with an array of data.
 * @package Effectra\DataOptimizer
 */
class DataCollection implements DataCollectionInterface
{
    /**
     * @var mixed[]
     */
    protected array $items = [];

    /**
     * DataCollection constructor.
     *
     * @param array $items The initial items of the collection.
     */
    public function __construct($items = [])
    {
        $this->items = $items;
    }

    /**
     * Get all items as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /*
    * Get the first item in the collection.
    *
    * @return mixed|null
    */
    public function first()
    {
        return reset($this->items);
    }

    /**
     * Get the last item in the collection.
     *
     * @return mixed|null
     */
    public function last()
    {
        return end($this->items);
    }

    /**
     * Get the key of the current item in the collection.
     *
     * @return int|string|null
     */
    public function key(): int|string|null
    {
        return key($this->items);
    }

    /**
     * Move to the next item in the collection.
     *
     * @return mixed|false
     */
    public function next()
    {
        return next($this->items);
    }

    /**
     * Get the current item in the collection.
     *
     * @return mixed|false
     */
    public function current()
    {
        return current($this->items);
    }

    /**
     * Remove an item from the collection by key.
     *
     * @param int|string $key The key to remove.
     * @return mixed|null The removed item.
     */
    public function remove(string|int $key)
    {
        if (!$this->has($key)) {
            return null;
        }

        $removed = $this->items[$key];
        unset($this->items[$key]);

        return $removed;
    }

     /**
     * Remove a specific element from the collection.
     *
     * @param mixed $element The element to remove.
     * @return bool True if the element was found and removed, false otherwise.
     */
    public function removeElement(mixed $element)
    {
        $key = array_search($element, $this->items, true);

        if ($key === false) {
            return false;
        }

        unset($this->items[$key]);

        return true;
    }

     /**
     * Get all items in the collection.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->items;
    }

     /**
     * Clear all items from the collection.
     *
     * @return void
     */
    public function clear(): void
    {
        $this->items = [];
    }

    /**
     * Get an item from the collection by key.
     *
     * @param int|string $key The key of the item.
     * @param mixed|null $default The default value if the key is not found.
     * @return mixed|null The item value or the default value.
     */
    public function get($key, $default = null)
    {
        return isset($this->items[$key]) ? $this->items[$key] : $default;
    }

    /**
     * Check if the collection contains a given element.
     *
     * @param mixed $element The element to check for.
     * @return bool True if the element is present, false otherwise.
     */
    public function contains(mixed $element): bool
    {
        return in_array($element, $this->items, true);
    }

     /**
     * Get the index of a given element in the collection.
     *
     * @param mixed $element The element to find.
     * @return int|string|false The key/index of the element, or false if not found.
     */
    public function indexOf($element): int|string|false
    {
        return array_search($element, $this->items, true);
    }

    /**
     * Get the keys of all items in the collection.
     *
     * @return array
     */
    public function getKeys()
    {
        return array_keys($this->items);
    }

/**
     * Get the values of all items in the collection.
     *
     * @return array
     */
    public function getValues()
    {
        return array_values($this->items);
    }

     /**
     * Check if the collection has a given key.
     *
     * @param int|string $key The key to check for.
     * @return bool True if the key is present, false otherwise.
     */
    public function has($key): bool
    {
        return isset($this->items[$key]) || array_key_exists($key, $this->items);
    }

    /**
     * Put a key/value pair into the collection.
     *
     * @param int|string $key The key.
     * @param mixed $value The value.
     * @return void
     */
    public function put($key, $value): void
    {
        $this->items[$key] = $value;
    }

     /**
     * Add an item to the end of the collection.
     *
     * @param mixed $item The item to add.
     * @return void
     */
    public function add($item): void
    {
        $this->items[] = $item;
    }

     /**
     * Forget a key from the collection.
     *
     * @param int|string $key The key to forget.
     * @return void
     */
    public function forget($key): void
    {
        unset($this->items[$key]);
    }

     /**
     * Map a callback over each item in the collection.
     *
     * @param Closure $callback The callback to apply.
     * @return static A new collection containing the results.
     */
    public function map(Closure $callback): static
    {
        return new static(array_map($callback, $this->items));
    }

    /**
     * Filter the collection using a callback.
     *
     * @param Closure $callback The callback to use for filtering.
     * @return static A new collection containing the filtered results.
     */
    public function filter(Closure $callback): static
    {
        return new static(array_filter($this->items, $callback));
    }

    /**
     * Reduce the collection to a single value using a callback.
     *
     * @param Closure $callback The callback to use for reduction.
     * @param mixed|null $initial The initial value for reduction.
     * @return mixed The result of the reduction.
     */
    public function reduce(Closure $callback, $initial = null)
    {
        return array_reduce($this->items, $callback, $initial);
    }

    /**
     * Slice the collection to the specified range of keys.
     *
     * @param int $offset The starting offset.
     * @param int|null $length The length of the slice.
     * @return array The sliced collection.
     */
    public function slice(int $offset, int|null $length = null)
    {
        return new static(array_slice($this->items, $offset, $length, true));
    }

     /**
     * Check if any item in the collection satisfies the given predicate.
     *
     * @param Closure $callback The predicate to test against.
     * @return bool True if any item satisfies the predicate, false otherwise.
     */
    public function exists(Closure $callback)
    {
        foreach ($this->items as $key => $element) {
            if ($callback($key, $element)) {
                return true;
            }
        }

        return false;
    }

     /**
     * Pop and return the last item from the collection.
     *
     * @return static A new collection containing the popped item.
     */
    public function pop()
    {
        return new static(array_pop($this->items));
    }

     /**
     * Get the number of items in the collection.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Check if the collection is empty.
     *
     * @return bool True if the collection is empty, false otherwise.
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

     /**
     * Check if a given offset exists in the collection.
     *
     * @param int|string $offset The offset to check for.
     * @return bool True if the offset exists, false otherwise.
     */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    /**
     * Get the item at a given offset in the collection.
     *
     * @param int|string $offset The offset of the item.
     * @return mixed|null The item at the offset or null if not found.
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Set the item at a given offset in the collection.
     *
     * @param int|string $offset The offset to set.
     * @param mixed $value The value to set.
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        $this->put($offset, $value);
    }

    
    /**
     * Unset the item at a given offset in the collection.
     *
     * @param int|string $offset The offset to unset.
     * @return void
     */
    public function offsetUnset($offset): void
    {
        $this->forget($offset);
    }

    /**
     * Get an iterator for the collection.
     *
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
