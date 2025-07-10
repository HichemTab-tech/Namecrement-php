<?php

namespace HichemTabTech\Namecrement;

use InvalidArgumentException;

class Namecrement
{
    /**
     * Generates a unique name by incrementing a base name if it already exists in the provided array of names.
     * The function checks for existing names and appends a number in parentheses to the base name if necessary.
     *
     * @param string $baseName The base name to be used for generating a unique name.
     * @param array $existingNames An array of existing names to check against.
     * @param string $suffixFormat Suffix format with %N% as a placeholder (default: " (%N%)").
     * @param int|null $startingNumber Optional starting number for the increment (default: null).
     * @return string The unique name generated based on the base name and existing names.
     */
    public static function namecrement(
        string $baseName,
        array $existingNames,
        string $suffixFormat = ' (%N%)',
        ?int $startingNumber = null
    ): string
    {
        if (!str_contains($suffixFormat, '%N%')) {
            throw new InvalidArgumentException('suffixFormat must contain "%N%"');
        }

        // Remove the suffix from the name if it matches the format
        $escapedFormat = preg_quote($suffixFormat, '/');
        $regex = '/^(.*)' . str_replace('%N%', '(\d+)', $escapedFormat) . '$/';

        if (preg_match($regex, $baseName, $matches)) {
            $baseName = $matches[1]; // remove suffix
        }

        // Build the matcher to compare against existing names
        $matchRegex = '/^' . preg_quote($baseName, '/') . '(?:' . str_replace('%N%', '(\d+)', $escapedFormat) . ')?$/';

        $used = [];

        foreach ($existingNames as $name) {
            if (preg_match($matchRegex, $name, $matches)) {
                $index = isset($matches[1]) ? (int) $matches[1] : 0;
                $used[$index] = true;
            }
        }

        if (!isset($used[0]) AND $startingNumber === null) {
            return $baseName;
        }

        $i = $startingNumber??1;
        while (isset($used[$i])) {
            $i++;
        }

        return $baseName . str_replace('%N%', (string)$i, $suffixFormat);
    }
}