<?php

declare(strict_types=1);

namespace Effectra\DataOptimizer;

/**
 * Class Result
 *
 * Represents the result of some operation, typically used in data optimization.
 *
 * @package Effectra\DataOptimizer
 */
final class Result
{
    /**
     * @var string The key associated with the result.
     */
    public string $key;

    /**
     * @var mixed The value associated with the result.
     */
    public mixed $value;

    /**
     * @var string|null Indicates if the result includes a removed value.
     */
    public ?string $removed;

    /**
     * Result constructor.
     *
     * @param string $key The key associated with the result.
     * @param mixed $value The value associated with the result.
     * @param string|null $removed Indicates if the result includes a removed value.
     */
    public function __construct(string $key, mixed $value, ?string $removed)
    {
        $this->key = $key;
        $this->value = $value;
        $this->removed = $removed;
    }

    /**
     * Get the key associated with the result.
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Get the value associated with the result.
     *
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Get the removed value if available, otherwise null.
     *
     * @return string|null
     */
    public function getRemoved(): ?string
    {
        return $this->removed;
    }

    /**
     * Get the key-value pair as an associative array.
     *
     * @return array
     */
    public function getKeyValue(): array
    {
        return [$this->key => $this->value];
    }
}
