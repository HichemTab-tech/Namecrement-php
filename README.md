# Namecrement (PHP)

<!--suppress HtmlDeprecatedAttribute -->
<p align="center">

![Tests](https://github.com/HichemTab-tech/Namecrement-php/workflows/Tests/badge.svg)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](https://github.com/HichemTab-tech/Namecrement-php/blob/master/LICENSE)
![Packagist Version](https://img.shields.io/packagist/v/hichemtab-tech/namecrement)

</p>

**Smart unique name generator for PHP**  
Automatically generates a unique name by incrementing it if needed — just like `"file" → "file (1)" → "file (2)"` and so on.

---

## ✨ Features

- Generate unique names based on existing ones
- Smart gap detection (fills missing indexes first)
- Lightweight, dependency-free
- Perfect for filenames, labels, IDs, and more

---

### 📦 Also Available

* JavaScript: [Namecrement](https://github.com/HichemTab-tech/Namecrement)
* Python: [Namecrement-py](https://github.com/HichemTab-tech/Namecrement-py)

## 📦 Installation

```bash
composer require hichemtab-tech/namecrement-php
```

---

## 🚀 Usage

```php
<?php

use HichemTabTech\Namecrement\Namecrement;

$existing = ['file', 'file (1)', 'file (2)'];
$newName = Namecrement::namecrement('file', $existing);

echo $newName; 
// Outputs: "file (3)"
```
---

## 🧠 Advanced Usage

You can customize the suffix format using the `%N%` placeholder to define how the number is added:

```php
Namecrement::namecrement('file', ['file', 'file -1-', 'file -2-'], ' -%N%-');
// ➔ 'file -3-'

Namecrement::namecrement('version', ['version', 'version<v1>'], '<v%N%>');
// ➔ 'version<v2>'
```

### 🛡 Suffix Format Rules

- The `suffixFormat` **must include** `%N%`, or an `InvalidArgumentException` will be thrown.
- `%N%` will be replaced by the next available number.
- Default format is `" (%N%)"`.

| Format Example    | Result              |
|-------------------|---------------------|
| `" (%N%)"`        | `file (1)`          |
| `-%N%`            | `file-1`            |
| `_<v%N%>`         | `file_<v1>`         |
| `_%N%_`           | `file_1_`           |

---

## 📚 API

### `namecrement(string $baseName, array $existingNames): string`

| Parameter       | Type     | Description                           |
|-----------------|----------|---------------------------------------|
| `baseName`      | string   | Proposed name to start from           |
| `existingNames` | string[] | List of already existing names        |
| `suffixFormat`  | string   | Optional format for suffix (optional) |

Returns the next available **unique name**.

---

## 🛠 Examples

```php
Namecrement::namecrement('report', ['report', 'report (1)']);
// ➔ 'report (2)'

Namecrement::namecrement('image', ['photo', 'image', 'image (1)', 'image (2)']);
// ➔ 'image (3)'

Namecrement::namecrement('new', []);
// ➔ 'new'
Namecrement::namecrement('file', ['file', 'file (1)', 'file (2)'], ' -%N%-');
// ➔ 'file -1-'
```

---

## 📄 License

This project is open-source and available under the [MIT license](LICENSE).

---

## 🤝 Contributing

Contributions are welcome!  
Please check out the [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.