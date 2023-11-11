<?php

declare(strict_types=1);

namespace Effectra\DataOptimizer;

use Effectra\Database\Exception\DataValidatorException;

/**
 * DataOptimizer class for optimizing and transforming data based on defined rules.
 */
class DataOptimizer
{
    /**
     * @var mixed $data The data to be optimized.
     */
    private $data;

    /**
     * @var DataRules $data_rule The data validation rules.
     */
    private DataRules $data_rule;

    /**
     * Constructor for DataOptimizer.
     *
     * @param mixed $data The data to be optimized.
     *
     * @throws DataValidatorException If the data is not a non-empty array.
     */
    public function __construct($data)
    {
        if (is_object($data)) {
            $data = (array)$data;
        }

        $this->data = $data;

        $this->data_rule = new DataRules();
    }

    /**
     * Apply a validation rule to a value and transform it accordingly.
     *
     * @param string $rule The validation rule.
     * @param string $key The key to validate and transform.
     * @param mixed $value The value to validate and transform.
     * @return Result The transformed value.
     */
    public function applyRule(string $rule, string $key, $value): Result
    {

        if ($rule === 'json_decode' && Utils::isJson($value)) {
            $value = json_decode($value);
        }

        if ($rule === 'json_encode') {
            $value = json_encode($value);
        }

        if ($rule === 'integer' && is_numeric($value)) {
            $value = (int) $value;
        }

        if ($rule === 'float' && is_numeric($value)) {
            $value = (float) $value;
        }

        if ($rule === 'string') {
            $value = (string) $value;
        }

        if ($rule === 'bool') {
            $value = (bool) $value;
        }

        if ($rule === 'array') {
            $value = (array) $value;
        }

        if ($rule === 'object') {
            $value = (object) $value;
        }

        if ($rule === 'slug') {
            $value = Utils::textToSlug($value, $this->data_rule->getAttribute('slug'));
        }

        if ($rule === 'list' && Utils::isJson($value)) {
            $value = join(',', (array) json_decode($value));
        }

        if ($rule === 'date') {
            $date = \DateTime::createFromFormat($this->data_rule->getAttribute('from_format'), $value);
            if ($date) {
                $value = $date->format($this->data_rule->getAttribute('to_format'));
            }
        }

        if ($rule === 'strip_tags' && is_string($value)) {
            $value = strip_tags($value, $this->data_rule->getAttribute('allowed_tags'));
        }

        if ($rule === 'replace_value') {
            $value = $this->data_rule->getAttribute('replace_new_value');
        }

        if ($rule === 'replace_value_by_new') {
            $value = $this->data_rule->getAttribute('replace_value_default') === $value ?  $this->data_rule->getAttribute('replace_value_new') : $value;
        }

        if ($rule === 'replace_text') {
            $value = str_replace(
                $this->data_rule->getAttribute('replace_text_default'),
                $this->data_rule->getAttribute('replace_text_new'),
                $value
            );
        }

        $removed = null;

        if ($rule === 'rename') {
            $removed = $key;
            $key = $this->data_rule->getAttribute('new_key_name_' . $key);
        }

        return new Result($key, $value, $removed);
    }

    /**
     * Optimize the data based on defined rules.
     *
     * @param callable $rules A callback function to define rules using DataRules.
     * @return array The optimized data.
     */
    public function optimize($rules): array
    {
        $data = [];
        call_user_func($rules, $this->data_rule);
        $this->data_rule->getRules();

        if ((new DataValidator($this->data))->isArrayOfAssoc()) {

            foreach ($this->data as &$item) {

                foreach ($item as $key => $value) {

                    if ($this->data_rule->hasRule($key)) {

                        $result =  $this->applyRule($this->data_rule->getRule($key), $key, $value);

                        $item = array_merge($item, $result->getKeyValue());

                        if ($result->getRemoved()) {

                            unset($item[$result->getRemoved()]);
                        }
                    }
                }

                $data[] = $item;
            }
        }

        return $data;
    }
}
