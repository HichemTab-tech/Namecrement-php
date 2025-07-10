<?php

use HichemTabTech\Namecrement\Namecrement;

describe('Namecrement - Default format', function () {
    it('returns base name if not taken', function () {
        expect(Namecrement::namecrement('file', ['file (1)', 'file (2)']))
            ->toBe('file');
    });

    it('appends (1) if base name exists', function () {
        expect(Namecrement::namecrement('file', ['file']))
            ->toBe('file (1)');
    });

    it('fills first missing index', function () {
        expect(Namecrement::namecrement('file', ['file', 'file (1)', 'file (3)']))
            ->toBe('file (2)');
    });

    it('skips to next available number', function () {
        expect(Namecrement::namecrement('file', ['file', 'file (1)', 'file (2)', 'file (3)']))
            ->toBe('file (4)');
    });

    it('handles large gaps', function () {
        expect(Namecrement::namecrement('file', ['file', 'file (5)', 'file (10)']))
            ->toBe('file (1)');
    });

    it('ignores partially matching names', function () {
        expect(Namecrement::namecrement('file', ['file', 'filex', 'file (1)', 'filex (1)']))
            ->toBe('file (2)');
    });

    it('handles multi-digit suffixes correctly', function () {
        expect(Namecrement::namecrement('file', ['file', 'file (1)', 'file (10)']))
            ->toBe('file (2)');
    });

    it('handles names ending with numbers', function () {
        expect(Namecrement::namecrement('file1', ['file1', 'file1 (1)']))
            ->toBe('file1 (2)');
    });

    it('handles special characters in names', function () {
        expect(Namecrement::namecrement('file[1].$^', ['file[1].$^', 'file[1].$^ (1)']))
            ->toBe('file[1].$^ (2)');
    });

    it('handles base with suffix-like pattern in the middle', function () {
        expect(Namecrement::namecrement('file (1) backup', ['file (1) backup', 'file (1) backup (1)']))
            ->toBe('file (1) backup (2)');
    });
});

describe('Namecrement - Custom suffix format', function () {
    it('supports custom dash format', function () {
        expect(Namecrement::namecrement('file', ['file', 'file -1-', 'file -2-'], ' -%N%-'))
            ->toBe('file -3-');
    });

    it('supports suffix with no spacing', function () {
        expect(Namecrement::namecrement('log', ['log', 'log1'], '%N%'))
            ->toBe('log2');
    });

    it('supports suffix with prefix and underscore', function () {
        expect(Namecrement::namecrement('image', ['image', 'image_v1'], '_v%N%'))
            ->toBe('image_v2');
    });

    it('handles complex suffix with angle brackets', function () {
        expect(Namecrement::namecrement('v', ['v', 'v<1>', 'v<2>'], '<%N%>'))
            ->toBe('v<3>');
    });

    it('respects spacing inside custom formats', function () {
        expect(Namecrement::namecrement('item', ['item', 'item (1)', 'item (2)'], ' \%N%\\'))
            ->toBe('item \1\\');
    });

    it('returns base if not taken, even with custom format', function () {
        expect(Namecrement::namecrement('note', ['note -1-'], ' -%N%-'))
            ->toBe('note');
    });
});

describe('Namecrement - Validation', function () {
    it('throws if suffix format does not contain %N%', function () {
        expect(fn() => Namecrement::namecrement('file', ['file'], ' (X)'))
            ->toThrow(new InvalidArgumentException('suffixFormat must contain "%N%"'));
    });
});

describe('namecrement with startingNumber option', function () {
    it('starts numbering from startingNumber if base name is available', function () {
        expect(Namecrement::namecrement('file', [], ' (%N%)', 2))
            ->toBe('file (2)');
    });

    it('starts numbering from startingNumber even if base name is taken', function () {
        expect(Namecrement::namecrement('file', ['file'], ' (%N%)', 2))
            ->toBe('file (2)');
    });

    it('finds the next available number from startingNumber', function () {
        expect(Namecrement::namecrement('file', ['file', 'file (2)'], ' (%N%)', 2))
            ->toBe('file (3)');
    });

    it('handles startingNumber of 0', function () {
        expect(Namecrement::namecrement('file', [], ' (%N%)', 0))
            ->toBe('file (0)');
    });

    it('handles startingNumber of 0 when base name is taken', function () {
        expect(Namecrement::namecrement('file', ['file (0)'], ' (%N%)', 0))
            ->toBe('file (1)');
    });

    it('ignores startingNumber when proposed name is unique and no starting number is passed', function () {
        expect(Namecrement::namecrement('file', ['file (1)']))
            ->toBe('file');
    });

    it('uses startingNumber when proposed name is unique but a starting number is passed', function () {
        expect(Namecrement::namecrement('file', ['file (1)'], ' (%N%)', 5))
            ->toBe('file (5)');
    });

    it('handles a scenario where startingNumber is occupied', function () {
        expect(Namecrement::namecrement('file', ['file (5)'], ' (%N%)', 5))
            ->toBe('file (6)');
    });
});