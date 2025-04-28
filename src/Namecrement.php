<?php

namespace HichemTabTech\Namecrement;

class Namecrement
{
    /**
     * Generates a unique name by incrementing a base name if it already exists in the provided array of names.
     * The function checks for existing names and appends a number in parentheses to the base name if necessary.
     *
     * @param string $baseName The base name to be used for generating a unique name.
     * @param array $existingNames An array of existing names to check against.
     * @return string The unique name generated based on the base name and existing names.
     */
    public static function namecrement(string $baseName, array $existingNames): string
    {
        $usedIndexes = [];

        foreach ($existingNames as $name) {
            if ($name === $baseName) {
                $usedIndexes[0] = true;
            } elseif (preg_match('/^' . preg_quote($baseName, '/') . ' \((\d+)\)$/', $name, $matches)) {
                $usedIndexes[(int) $matches[1]] = true;
            }
        }

        $index = 0;
        while (isset($usedIndexes[$index])) {
            $index++;
        }

        return $index === 0 ? $baseName : "$baseName ($index)";
    }
}