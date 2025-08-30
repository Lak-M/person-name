<div align="center">

<img width="417" height="74" alt="Image" src="https://github.com/user-attachments/assets/6371ad23-cdb2-4a7b-9975-e0c5525f8953" />

<hr/>

<img src="https://github.com/user-attachments/assets/ef6088e7-4de5-45c2-b804-0c46b27c918e" width="640" alt="Image"/>

### ***This package globally handle person names in various formats.***


[![PHP](https://img.shields.io/badge/php-%20%5E8.3-blue)](https://php.net)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/Lak-M/person-name/run-tests.yml?label=Test)](https://github.com/Lak-M/person-name/actions?query=workflow%3ATests+branch%3Amain)
[![Packagist Version](https://img.shields.io/packagist/v/lakm/person-name)](https://packagist.org/packages/lakm/person-name)
[![Downloads](https://img.shields.io/packagist/dt/lakm/person-name)](https://packagist.org/packages/lakm/person-name)
[![GitHub License](https://img.shields.io/github/license/Lak-M/person-name)](https://github.com/Lak-M/person-name/blob/main/LICENSE.md)

</div>

## Overview
This package maps names from various countries to a standard format [prefix + first + middle + last + suffix] and 
provides multiple country-specific formats and features.

## Insight

### Problem

- A company decided to automate their business by developing a website. The database has a `users` table with normalized name fields (`first_name`, `middle_name`, `last_name`).

  However, legacy Excel sheets contain a ***single column*** with users' ***full names***. 
  This wasn’t a problem for the legacy system, as everything was handled manually and humans are generally good with full names.

  Now, the company wants to import the legacy data into the new system. They need to split full names into ***first, middle, and last names***.

  If this sounds like an easy task, take a moment and think about it seriously. One solution is to hire someone to do it manually but the 
  accuracy cannot be fully guaranteed. Another option is to automate the task using AI or custom logic but that will cost time and money 
  and still may not be perfectly accurate.

  You’ll agree that neither method is smooth or reliable, especially when the client list contains names from **different countries**.

  This is where this package comes in handy. With this package, all you need to do is the following:

    ```php
    $n = PersonName::fromFullName($fullName, $country);
    
    $firstName = $n->first();
    $middleName = $n->middle();
    $lastName = $n->last();
    ```
  
- Your database has a users table with a `full_name` field. This is not an ideal database design, but it exists.
  Now you need to extract the individual name parts.

- The front-end requires names in different formats: the UI needs **short names, forms need names in a standard format**, 
  and security related features may require redacted names. Similarly, names may be needed in **abbreviated, sorted, or other variations**. 
  This package handles all these cases as comprehensively as possible.

## Motive
I've faced the problems described [above](#problem) and always needed a solid solution, which I still couldn't find. Recently, 
I came across this [package](https://github.com/hosmelq/name-of-person) and thought, this is what I’ve been waiting for so long. But when I dug into it, 
I realized it couldn’t fulfill my expectations. It handles simple cases but not complex scenarios.

So, I decided to stop waiting and develop a solution myself. I must give credit to this package, as it ignited the spark.

## Features
- 🏁 **Handle Country specific names**
- 🛠️ **Build names from full names**
- 🛠️ **Build names from parts (constructor)**
- ⚙️ **Handle particles, prefixes, suffixes (western)**
- 🛡️ **Universal - Multibyte safe**
- 🤖 **Auto sanitize names**
- ✅ **Validity check**
- ●●● **Name Abbreviations**
  - **FirstInitial_LastName**
  - **FirstInitial_MiddleInitial_LastName**
  - **FirstName_LastInitial**
  - **FirstName_MiddleInitial_LastName**
  - **Initials**
- 📝 **Various Format options**
  - **Sorted**
  - **Possessive**
  - **Redated**
  - **Family|sur|last**
  - **etc**
- 🧩 **Country specific features**
- 📔 **Comprehensive test cases with >85% coverage**
- 💡 **Elegant architecture**
- 🦢 **Pure PhP - can use anywhere frameworks, lib etc.**

## Usage

### Build from full name

```php
\Lakm\PersonName\PersonName::fromFullName(
    string $fullName, 
    Country|Ethnicity|null $country = null, 
    bool $shouldSanitize = true, 
    bool $checkValidity = false
    )
```

### Build from constructor

```php
\Lakm\PersonName\PersonName::build(
    string $firstName,
    ?string $middleName = null,
    ?string $lastName = null,
    ?string $suffix = null,
    ?string $prefix = null,
    Country|Ethnicity|null $country = null,
    bool $shouldSanitize = true,
    bool $checkValidity = false
)
```
### Abbreviator

The package provides a smart abbreviation format with multiple options. **This feature is also integrated into PersonName**.

```php
\Lakm\PersonName\Abbreviator\Abbreviator::execute(
    string $firstName,
    ?string $middleName = null,
    ?string $lastName = null,
    ?string $prefix = null,
    ?string $suffix = null,
    bool    $withDot = true,
    bool    $strict = false,
    bool    $removeParticles = false,
    Abbreviate $format = Abbreviate::FirstInitial_LastName,
)
```
#### Available format (`$format`) options

Any `Abbreviate` enum case available in [Abbreviate enum class](https://github.com/Lak-M/person-name/blob/main/src/Enums/Abbreviate.php)


- `\Lakm\PersonName\Enums\Abbreviate::FirstInitial_LastName`
- `\Lakm\PersonName\Enums\Abbreviate::FirstInitial_MiddleInitial_LastName`
- `\Lakm\PersonName\Enums\Abbreviate::FirstName_LastInitial`
- `\Lakm\PersonName\Enums\Abbreviate::FirstName_MiddleInitial_LastName`
- `\Lakm\PersonName\Enums\Abbreviate::Initials`


### Common API

> [!Important]
> See [NameBuilderContract](https://github.com/Lak-M/person-name/blob/main/src/Contracts/NameBuilderContract.php) for all the available options

#### Basic

##### first(): string

Returns the first name

```php
use \Lakm\PersonName\PersonName;

PersonName::fromFullName('Prof. Dr. Maria Anna de la Vega III PhD')->first() // Maria
```

##### middle(): string

Returns the middle name

```php
use \Lakm\PersonName\PersonName;

PersonName::fromFullName('Prof. Dr. Maria Anna de la Vega III PhD')->middle() // Anna
```

##### last(): string

Returns the last name

```php
use \Lakm\PersonName\PersonName;

PersonName::fromFullName('Prof. Dr. Maria Anna de la Vega III PhD')->last() // de la Vega
```

##### sorted(): ?string

Returns sorted name

```php
use \Lakm\PersonName\PersonName;

PersonName::fromFullName('Prof. Dr. Maria Anna de la Vega III PhD')->sorted() // de la Vega, Maria Anna
```
##### possessive(?string $name = null): string

Returns the possessive name

```php
use \Lakm\PersonName\PersonName;

PersonName::fromFullName('Prof. Dr. Maria Anna de la Vega III PhD')->possessive() // Maria's
```

##### prefix(): ?string

Returns the prefixes

```php
use \Lakm\PersonName\PersonName;

PersonName::fromFullName('Prof. Dr. Maria Anna de la Vega III PhD')->prefix() // Prof. Dr.

```

##### suffix(): ?string

Returns the suffixes

```php
use \Lakm\PersonName\PersonName;

PersonName::fromFullName('Prof. Dr. Maria Anna de la Vega III PhD')->suffix() // III PhD

```

##### honours(): string[]

Returns the honours

```php
use \Lakm\PersonName\PersonName;

PersonName::fromFullName('Prof. Dr. Maria Anna de la Vega III PhD')->honours() // ['Dr.', 'Prof.', 'PhD']

```

##### redated(int $length = 8, int $keep = 3, string $mask = '*'): string

Returns securely redated first name

```php
use \Lakm\PersonName\PersonName;

PersonName::fromFullName('Prof. Dr. Maria Anna de la Vega III PhD')->redated() // Mar*****

```
##### mentionable(): string

Returns the mentionable name

```php
use \Lakm\PersonName\PersonName;

PersonName::fromFullName('Prof. Dr. Maria Anna de la Vega III PhD')->mentionable() // @maria

```
##### nick(int $length = 4): string

Returns the nickname

```php
use \Lakm\PersonName\PersonName;

PersonName::fromFullName('Prof. Dr. Maria Anna de la Vega III PhD')->nick() // mary

```
#### Abbreviations

Refer [here](#abbreviator) for separate usage.

#### abbreviated(bool $includePrefix = false, bool $includeSuffix = false, bool $withDot = true, bool $strict = false, bool $removeParticles = false, Abbreviate $format = Abbreviate::Initials): string 

Refer [here](#available-format-format-options) for available formats (`$format`)

```php
use \Lakm\PersonName\PersonName;

PersonName::fromFullName('Prof. Dr. Maria Anna de la Vega III PhD')->abbreviated() // M. A. d. l. V.

```
## Testing
```bash
./vendor/bin/pest
```

## Security
Please see [here](https://github.com/Lak-M/person-name/blob/main/SECURITY.md) for our security policy.

## License
The MIT License (MIT). Please see [License File](https://github.com/Lak-M/person-name/blob/main/LICENSE.md) for more information.

