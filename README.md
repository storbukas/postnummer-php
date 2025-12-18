# Postnummer

[![Tests](https://github.com/storbukas/postnummer-php/actions/workflows/tests.yml/badge.svg)](https://github.com/storbukas/postnummer-php/actions/workflows/tests.yml)
[![Latest Version](https://img.shields.io/packagist/v/storbukas/postnummer.svg)](https://packagist.org/packages/storbukas/postnummer)
[![PHP Version](https://img.shields.io/packagist/php-v/storbukas/postnummer.svg)](https://packagist.org/packages/storbukas/postnummer)
[![License](https://img.shields.io/packagist/l/storbukas/postnummer.svg)](LICENSE)

> Norske postnummer - Norwegian postal codes for PHP

## Installation

```bash
composer require storbukas/postnummer
```

## Usage

```php
use Storbukas\Postnummer\Postnummer;

// Get place name
Postnummer::poststed('4633');      // 'KRISTIANSAND S'
Postnummer::poststed('1337');      // 'SANDVIKA'
Postnummer::poststed(4879);        // 'GRIMSTAD'
Postnummer::poststed('9999');      // null

// Get municipality name
Postnummer::kommunenavn('4633');   // 'KRISTIANSAND'

// Get municipality number
Postnummer::kommunenummer('4633'); // '4204'

// Get category
Postnummer::kategori('4633');      // 'G'

// Get full info
Postnummer::get('4633');
/*
[
    'poststed' => 'KRISTIANSAND S',
    'kommunenummer' => '4204',
    'kommunenavn' => 'KRISTIANSAND',
    'kategori' => 'G',
]
*/

// Check if postal code exists
Postnummer::exists('4633');        // true
Postnummer::exists('9999');        // false

// Search by place or municipality name
Postnummer::search('KRISTIANSAND');
/*
[
    '4608' => ['poststed' => 'KRISTIANSAND S', ...],
    '4609' => ['poststed' => 'KARDEMOMME BY', ...],
    '4610' => ['poststed' => 'KRISTIANSAND S', ...],
    ...
]
*/

// Get all postal codes
$all = Postnummer::all();
```

## API

| Method | Returns | Description |
|--------|---------|-------------|
| `get($postnummer)` | `?array` | Full postal code info or null |
| `poststed($postnummer)` | `?string` | Place name or null |
| `kommunenavn($postnummer)` | `?string` | Municipality name or null |
| `kommunenummer($postnummer)` | `?string` | Municipality number or null |
| `kategori($postnummer)` | `?string` | Category or null |
| `exists($postnummer)` | `bool` | Whether postal code exists |
| `search($query)` | `array` | Matching postal codes |
| `all()` | `array` | All postal codes |

## Categories

| Code | Description |
|------|-------------|
| B | Both street addresses and PO boxes |
| F | Multiple use |
| G | Street addresses only |
| P | PO boxes only |
| S | Service postal codes |

## Data Source

Postal code data is sourced from [Bring](https://www.bring.no/tjenester/adressetjenester/postnummer).

## Requirements

- PHP 8.0 or higher

## License

MIT
