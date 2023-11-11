<?php

declare(strict_types=1);

namespace Effectra\DataOptimizer;

/**
 * Class Utils
 *
 * Contains utility methods for common tasks.
 *
 * @package Effectra\DataOptimizer
 */
class Utils
{
    /**
     * Convert text to a slug.
     *
     * @param string $text The text to convert.
     * @param string $delimiter The character used as a delimiter in the slug.
     * @return string The generated slug.
     */
    public static function textToSlug(string $text, string $delimiter = '-'): string
    {
        /**
         * Remove special characters, leaving only alphanumeric characters and spaces.
         * Convert the text to lowercase.
         * Replace spaces with the specified delimiter.
         */
        $text = preg_replace('/[^a-zA-Z0-9\s]/', '', $text);
        $text = strtolower($text);
        $text = str_replace(' ', $delimiter, $text);

        return $text;
    }

    /**
     * Check if the string is valid JSON.
     *
     * @param string $value The string to check.
     * @return bool True if the string is valid JSON, false otherwise.
     */
    public static function isJson(string $value): bool
    {
        /**
         * Attempt to decode the JSON string.
         * Return true if decoding succeeds without errors.
         */
        json_decode($value);
        return (json_last_error() === JSON_ERROR_NONE);
    }
}
