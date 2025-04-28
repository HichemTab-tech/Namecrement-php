# Namecrement (PHP)

**Smart unique name generator for PHP**  
Automatically generates a unique name by incrementing it if needed — just like `"file" → "file (1)" → "file (2)"` and so on.

---

<!--suppress HtmlDeprecatedAttribute -->
<p align="center">
  <img src="https://img.shields.io/github/actions/workflow/status/HichemTab-tech/namecrement-php/tests.yml?branch=master"  alt="badge test"/>
  <img src="https://img.shields.io/github/license/Configure image/namecrement-php"  alt="badge test" />
</p>

---

## ✨ Features

- Generate unique names based on existing ones
- Smart gap detection (fills missing indexes first)
- Lightweight, dependency-free
- Perfect for filenames, labels, IDs, and more

---

## 📦 Installation

```bash
composer require hichemtab-tech/namecrement-php
```

---

## 🚀 Usage

```php
<?php

use function App\namecrement; // adjust if your namespace is different

$existing = ['file', 'file (1)', 'file (2)'];
$newName = namecrement('file', $existing);

echo $newName; 
// Outputs: "file (3)"
```

---

## 📚 API

### `namecrement(string $baseName, array $existingNames): string`

| Parameter       | Type     | Description                    |
|-----------------|----------|--------------------------------|
| `baseName`      | string   | Proposed name to start from    |
| `existingNames` | string[] | List of already existing names |

Returns the next available **unique name**.

---

## 🛠 Examples

```php
namecrement('report', ['report', 'report (1)']);
// ➔ 'report (2)'

namecrement('image', ['photo', 'image', 'image (1)', 'image (2)']);
// ➔ 'image (3)'

namecrement('new', []);
// ➔ 'new'
```

---

## 📄 License

This project is open-source and available under the [MIT license](LICENSE).

---

## 🤝 Contributing

Contributions are welcome!  
Please check out the [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.