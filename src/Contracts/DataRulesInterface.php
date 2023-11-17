<?php

declare(strict_types=1);

namespace Effectra\DataOptimizer\Contracts;

/**
 * interface DataRulesInterface
 *
 * A interface for managing data rules.
 * 
 * @package Effectra\DataOptimizer
 */
interface DataRulesInterface extends DataAttributeInterface
{
    /**
     * Check if a rule with the specified key exists.
     *
     * @param string $key The key to check.
     * @return bool True if the rule exists, false otherwise.
     */
    public function hasRule(string $key): bool;


    /**
     * Get all defined rules.
     *
     * @return array An array of rules.
     */
    public function getRules(): array;


    /**
     * Get the rule for a specific key.
     *
     * @param string $key The key for which to retrieve the rule.
     * @return string The rule.
     */
    public function getRule(string $key): string;


    /**
     * Set an array of rules.
     *
     * @param array $rules An array of rules to set.
     * @return self
     */
    public function setRules(array $rules): self;


    /**
     * Set a rule for a specific key.
     *
     * @param string $key The key for which to set the rule.
     * @param string $rule The rule to set.
     * @return self
     */
    public function setRule(string $key, string $rule): self;

    /**
     * Set a rule for a key to validate as JSON encoded.
     *
     * @param string $key The key to validate as JSON.
     * @return self
     */
    public function json_encode(string $key): self;


    /**
     * Set a rule for a key to validate as JSON decoded.
     *
     * @param string $key The key to validate as JSON.
     * @return self
     */
    public function json_decode(string $key): self;

    /**
     * Set a rule for a key to validate as Boolean.
     *
     * @param string $key The key to validate as Boolean.
     * @return self
     */
    public function bool(string $key): self;

    /**
     * Set a rule for a key to validate as Array.
     *
     * @param string $key The key to validate as Array.
     * @return self
     */
    public function array(string $key): self;


    /**
     * Set a rule for a key to validate as Object.
     *
     * @param string $key The key to validate as Object.
     * @return self
     */
    public function object(string $key): self;


    /**
     * Set a rule for a key to validate as an integer.
     *
     * @param string $key The key to validate as an integer.
     * @return self
     */
    public function integer(string $key): self;


    /**
     * Set a rule for a key to validate as a string.
     *
     * @param string $key The key to validate as a string.
     * @return self
     */
    public function string(string $key): self;


    /**
     * Set a rule for a key to validate as a double.
     *
     * @param string $key The key to validate as a double.
     * @return self
     */
    public function double(string $key): self;


    /**
     * Set a rule for a key to validate as a slug.
     *
     * @param string $key The key to validate as a slug.
     * @param string $delimiter The character used as a delimiter in the slug.
     * @return self
     */
    public function slug(string $key, string $delimiter = '-'): self;


    /**
     * Set a rule for a key to validate as a list.
     *
     * @param string $key The key to validate as a list.
     * @return self
     */
    public function list(string $key): self;


    /**
     * Set a rule for a key to validate as a date.
     *
     * @param string $key The key to validate as a date.
     * @param string $to_format The desired date format.
     * @param string $from_format The source date format (default is 'Y-m-d H:i:s').
     * @return self
     */
    public function date(string $key, string $to_format, string $from_format = 'Y-m-d H:i:s'): self;


    /**
     * Set a new value for a rule key.
     *
     * @param string $key       The rule key.
     * @param mixed  $new_value The new value to set.
     *
     * @return self Returns the current instance of the class.
     */
    public function setValue($key, $new_value): self;


    /**
     * Replace a value in a rule with a new one.
     *
     * @param string $key     The rule key.
     * @param mixed  $default The default value to replace.
     * @param mixed  $new     The new value to replace with.
     *
     * @return self Returns the current instance of the class.
     */
    public function replaceValue($key, $default, $new): self;

    /**
     * Replace text within a rule with a new value.
     *
     * @param string $key        The rule key.
     * @param string $target     The text to replace.
     * @param string $new_value  The new value to replace with.
     *
     * @return self Returns the current instance of the class.
     */
    public function replaceText($key, $target, $new_value): self;

    /**
     * Rename a rule key to a new name.
     *
     * @param string $key      The current rule key.
     * @param string $new_name The new name for the key.
     *
     * @return self Returns the current instance of the class.
     */
    public function renameKey(string $key, string $new_name): self;


    /**
     * Strip HTML tags from a rule value.
     *
     * @param string         $key          The rule key.
     * @param string[]|string|null $allowed_tags An array of allowed HTML tags or null to strip all tags.
     *
     * @return self Returns the current instance of the class.
     */
    public function stripTags(string $key, $allowed_tags = null): self;
}
