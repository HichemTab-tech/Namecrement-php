<?php

use HichemTabTech\Namecrement\Namecrement;

it('generates a unique name when none exist', function () {
    expect(Namecrement::namecrement('file', []))
        ->toBe('file');
});

it('generates an incremented name when base name exists', function () {
    expect(Namecrement::namecrement('file', ['file']))
        ->toBe('file (1)');
});

it('fills the first missing index', function () {
    expect(Namecrement::namecrement('file', ['file', 'file (1)', 'file (3)']))
        ->toBe('file (2)');
});

it('skips to next available number if all are taken', function () {
    expect(Namecrement::namecrement('file', ['file', 'file (1)', 'file (2)', 'file (3)']))
        ->toBe('file (4)');
});

it('works correctly when there are large gaps', function () {
    expect(Namecrement::namecrement('file', ['file', 'file (5)', 'file (10)']))
        ->toBe('file (1)');
});

it('handles names that partially match but are different', function () {
    expect(Namecrement::namecrement('file', ['file', 'filex', 'file (1)', 'filex (1)']))
        ->toBe('file (2)');
});