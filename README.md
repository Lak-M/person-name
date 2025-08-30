<div align="center">

<img width="417" height="74" alt="Image" src="https://github.com/user-attachments/assets/6371ad23-cdb2-4a7b-9975-e0c5525f8953" />

<hr/>

<img src="https://github.com/user-attachments/assets/ef6088e7-4de5-45c2-b804-0c46b27c918e" width="640" alt="Image"/>

### ***This package globally handle person names in various formats.***


[![Laravel](https://img.shields.io/badge/php-%20%5E8.3-blue)](https://php.net)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/Lak-M/person-name/run-tests.yml)](https://github.com/Lak-M/person-name/actions?query=workflow%3ATests+branch%3Amain)
[![Packagist Version](https://img.shields.io/packagist/v/lakm/person-name)](https://packagist.org/packages/lakm/person-name)
[![Downloads](https://img.shields.io/packagist/dt/lakm/person-name)](https://packagist.org/packages/lakm/person-name)
[![GitHub License](https://img.shields.io/github/license/Lak-M/person-name)](https://github.com/Lak-M/person-name/blob/main/LICENSE.md)

</div>

## Overview
This package map names from various countries to standard format [prefix+first+middle+last+suffix] and provide
various country specific formats and country specific features.

## Insight

### Problem

- A company decided to automating their business by developing a website. Database has user's table with normalized name field (`first_name`, `middle_name`, `last_name`).
  but legacy Excel sheets have user's full name column. It wasn't a problem for legacy system as things are handled manually and human are good with full names.
  But now, the company wants to import legacy data to new system. They need to split full name into first, middle and last names.
  If it feels like an easy task, just take a minutes and think about it seriously. One solution you can hire a person to do this task manually but
  the accuracy can be guaranteed. You can automate this task using AI or write some logic again it gonna cost you some money and can't guarantee the accuracy.
  You will agree with me none of those methods are smooth and reliable. You will have to spend time and efforts to it specially when the client list 
  contains names from **different countries**. This is when this package comes in handy. with this package all you need to do following,
```php
$n = PersonName::fromFullName($fullName, $country);

$firstName = $n->first();
$middleName = $n->middle();
$lastName = $n->last();
```
  
- Your database has user's table with `full_name` field. This is a bad DB design but it exists. Now you need to extract parts.

- Front-end needs names in different format. UI need short name, form need names in standard format, security related things need redated name.
  like-wise abbreviated, sorted etc. With this package covers all the cases as much as possible.

## Motive
 I've faced the problems described [above](#problem) and alwatys needed a solid solution which I coundn't find still. Recetly I show this package
and I thought this what I waiting for so long. But when I dig into it I realize it cannot fullfill my expectations. It can do simple things but not complex 
scenarios. So I decided to stop waiting and develop a solution by myself. I must give credits to this package as it ignited the spark.

## Features
- 🏁 **Handle Country specific names**
- 🛠️ **Build name from full names**
- 🛠️ **Build name from parts (constructor)**
- ⚙️ **Handle particles, prefix, suffix (western)**
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
- 📔 **Comprehensive test cases**
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

Package provide smart abbreviate format with various options. **This is also embedded to `PersonName`**

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

###### first(): string

Returns the first name

```php
use \Lakm\PersonName\PersonName;

PersonName::fromFullName('Prof. Dr. Maria Anna de la Vega III PhD')->first() // Maria

```

###### middle(): string

Returns the middle name

```php
use \Lakm\PersonName\PersonName;

PersonName::fromFullName('Prof. Dr. Maria Anna de la Vega III PhD')->middle() // Anna

```

###### last(): string

Returns the last name

```php
use \Lakm\PersonName\PersonName;

PersonName::fromFullName('Prof. Dr. Maria Anna de la Vega III PhD')->last() // de la Vega

```

###### sorted(): ?string

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
