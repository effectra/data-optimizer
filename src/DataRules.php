<?php

declare(strict_types=1);

namespace Effectra\DataOptimizer;

use Closure;
use Effectra\Database\Exception\DataValidatorException;
use Effectra\DataOptimizer\Contracts\DataRulesInterface;

/**
 * DataRules class for defining validation rules and attributes for data.
 */
class DataRules extends DataAttribute implements DataRulesInterface
{
    /**
     * @var array $rules An array of rules .
     */
    protected array $rules = [];
    /**
     * @var array $attributes An array of attributes .
     */
    protected array $attributes = [];

    /**
     * @var int $increment Increment value for adding keys.
     */
    private int $increment = 1;

    /**
     * Set the increment value.
     *
     * @return void
     */
    private function setIncrement(): void
    {
        ++$this->increment;
    }

    /**
     * Get the increment value.
     *
     * @return int The increment value.
     */
    public function getIncrement(): int
    {
        return $this->increment;
    }

    /**
     * Check if a rule with the specified key exists.
     *
     * @param string $key The key to check.
     * @return bool True if the rule exists, false otherwise.
     */
    public function hasRule(string $key): bool
    {
        return isset($this->rules[$key]);
    }

    /**
     * Get all defined rules.
     *
     * @return array An array of rules.
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * Get the rule for a specific key.
     *
     * @param string $key The key for which to retrieve the rule.
     * @return string The rule.
     */
    public function getRule(string $key): string
    {
        return $this->rules[$key];
    }

    /**
     * Set an array of rules.
     *
     * @param array $rules An array of rules to set.
     * @return self
     */
    public function setRules(array $rules): self
    {
        $this->rules = $rules;
        return $this;
    }

    /**
     * Set a rule for a specific key.
     *
     * @param string $key The key for which to set the rule.
     * @param string $rule The rule to set.
     * @return self
     */
    public function setRule(string $key, string $rule): self
    {
        $this->rules[$key] = $rule;
        return $this;
    }

    /**
     * Set a rule for a key to validate as JSON encoded.
     *
     * @param string $key The key to validate as JSON.
     * @return self
     */
    public function json_encode(string $key): self
    {
        return $this->setRule($key, 'json_encode');
    }

    /**
     * Set a rule for a key to validate as JSON decoded.
     *
     * @param string $key The key to validate as JSON.
     * @return self
     */
    public function json_decode(string $key): self
    {
        return $this->setRule($key, 'json_decode');
    }

    /**
     * Set a rule for a key to validate as Boolean.
     *
     * @param string $key The key to validate as Boolean.
     * @return self
     */
    public function bool(string $key): self
    {
        return $this->setRule($key, 'bool');
    }

    /**
     * Set a rule for a key to validate as Array.
     *
     * @param string $key The key to validate as Array.
     * @return self
     */
    public function array(string $key): self
    {
        return $this->setRule($key, 'array');
    }

    /**
     * Set a rule for a key to validate as Object.
     *
     * @param string $key The key to validate as Object.
     * @return self
     */
    public function object(string $key): self
    {
        return $this->setRule($key, 'object');
    }

    /**
     * Set a rule for a key to validate as an integer.
     *
     * @param string $key The key to validate as an integer.
     * @return self
     */
    public function integer(string $key): self
    {
        return $this->setRule($key, 'integer');
    }

    /**
     * Set a rule for a key to validate as a string.
     *
     * @param string $key The key to validate as a string.
     * @return self
     */
    public function string(string $key): self
    {
        return $this->setRule($key, 'string');
    }

    /**
     * Set a rule for a key to validate as a double.
     *
     * @param string $key The key to validate as a double.
     * @return self
     */
    public function double(string $key): self
    {
        return $this->setRule($key, 'double');
    }

    /**
     * Set a rule for a key to validate as a slug.
     *
     * @param string $key The key to validate as a slug.
     * @param string $delimiter The character used as a delimiter in the slug.
     * @return self
     */
    public function slug(string $key, string $delimiter = '-'): self
    {
        $this->setAttribute('slug', $delimiter);
        return $this->setRule($key, 'slug');
    }

    /**
     * Set a rule for a key to validate as a list.
     *
     * @param string $key The key to validate as a list.
     * @return self
     */
    public function list(string $key): self
    {
        return $this->setRule($key, 'list');
    }

    /**
     * Set a rule for a key to validate as a date.
     *
     * @param string $key The key to validate as a date.
     * @param string $to_format The desired date format.
     * @param string $from_format The source date format (default is 'Y-m-d H:i:s').
     * @return self
     */
    public function date(string $key, string $to_format, string $from_format = 'Y-m-d H:i:s'): self
    {
        $this->setAttribute('from_format', $from_format);
        $this->setAttribute('to_format', $to_format);
        return $this->setRule($key, 'date');
    }

    /**
     * Set a new value for a rule key.
     *
     * @param string $key       The rule key.
     * @param mixed  $new_value The new value to set.
     *
     * @return self Returns the current instance of the class.
     */
    public function setValue($key, $new_value): self
    {
        $this->setAttribute('replace_new_value', $new_value);
        return $this->setRule($key, 'replace_value');
    }

    /**
     * Replace a value in a rule with a new one.
     *
     * @param string $key     The rule key.
     * @param mixed  $default The default value to replace.
     * @param mixed  $new     The new value to replace with.
     *
     * @return self Returns the current instance of the class.
     */
    public function replaceValue($key, $default, $new): self
    {
        $this->setAttribute('replace_value_default', $default);
        $this->setAttribute('replace_value_new', $new);
        return $this->setRule($key, 'replace_value_by_new');
    }

    /**
     * Replace text within a rule with a new value.
     *
     * @param string $key        The rule key.
     * @param string $target     The text to replace.
     * @param string $new_value  The new value to replace with.
     *
     * @return self Returns the current instance of the class.
     */
    public function replaceText($key, $target, $new_value): self
    {
        $this->setAttribute('replace_text_default', $target);
        $this->setAttribute('replace_text_new', $new_value);
        return $this->setRule($key, 'replace_text');
    }

    /**
     * Rename a rule key to a new name.
     *
     * @param string $key      The current rule key.
     * @param string $new_name The new name for the key.
     *
     * @return self Returns the current instance of the class.
     */
    public function renameKey(string $key, string $new_name): self
    {
        $this->setAttribute('rename_' . $key, $key);
        $this->setAttribute("new_key_name_$key", $new_name);
        return $this;
    }

    /**
     * Strip HTML tags from a rule value.
     *
     * @param string         $key          The rule key.
     * @param string[]|string|null $allowed_tags An array of allowed HTML tags or null to strip all tags.
     *
     * @return self Returns the current instance of the class.
     */
    public function stripTags(string $key, $allowed_tags = null): self
    {
        $this->setAttribute('allowed_tags', $allowed_tags);
        return $this->setRule($key, 'strip_tags');
    }

    /**
     * Modify a rule value using a custom closure.
     *
     * @param string $key The rule key.
     * @param Closure $p The closure to modify the value.
     * @return self Returns the current instance of the class.
     */
    public function modify(string $key, Closure $p): self
    {
        $this->setAttribute('callback_function_' . $key, $p);
        return $this->setRule($key, 'modify_' . $key);
    }

    /**
     * Remove specified keys from the data.
     *
     * @param array $keys An array of keys to remove.
     * @return self Returns the current instance of the class.
     */
    public function removeKeys(array $keys): self
    {
        $this->setAttribute('remove_keys', $keys);
        return $this;
    }

    /**
     * Add new keys to the data.
     *
     * @param array $keys An array of keys to add.
     * @return self Returns the current instance of the class.
     * @throws DataValidatorException If keys are not an associative array.
     */
    public function addKeys(array $keys): self
    {
        if (!(new DataValidator($keys))->isAssoc()) {
            throw new DataValidatorException("keys must be an associative array");
        }
        $this->setAttribute('add_keys', $keys);
        return $this;
    }

    /**
     * Add a new key using a callback function.
     *
     * @param string $key The key to add.
     * @param Closure $callback The callback function to generate the value for the new key.
     * @return self Returns the current instance of the class.
     */
    public function addKeyUseItem(string $key, Closure $callback): self
    {
        $this->setIncrement();
        $this->setAttribute('add_keys_by_using_item_' . $this->getIncrement(), $key);
        $this->setAttribute('add_keys_by_using_item_callback_' . $this->getIncrement(), $callback);
        return $this;
    }

    /**
     * Sort the data based on specified keys.
     *
     * @param array $sortKeys The keys to use for sorting.
     * @return self Returns the current instance of the class.
     */
    public function sortByKeys(array $sortKeys): self
    {
        $this->setAttribute('sort', $sortKeys);
        return $this;
    }
}
