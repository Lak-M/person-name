# Contribution Guide

We value your contributions to the growth and stability of this package. While we’re not overly strict, 
we **highly encourage** following these guidelines:

- Use **descriptive names** (classes, methods, properties, etc.) rather than relying solely on documentation.
- Maintain **backward compatibility** with the lowest supported PHP version (currently **8.3**).
- Prioritize **refactoring** where it improves clarity and maintainability.
- Adhere to **SOLID** principles.
- Provide **comprehensive test cases** — without them, new features may not be merged.
- Write **descriptive** pull request titles and include supporting details (prefer examples over lengthy paragraphs).
- Open a **discussion** if you have any doubts. 

## Testing

Testing is the only real proof that a library works as expected. 
That’s why we expect comprehensive test cases with diverse and meaningful data sets.

## Example 

For example, suppose you want to add a new country to support its unique naming structure:

1. Create an enum case for the country with its code [here](https://github.com/Lak-M/person-name/blob/main/src/Enums/Country.php)

2. Prepare a rich dataset with different types of names (with last name, without last name, with suffix, with prefix, without suffix, etc.) in the following format, 
and add them to the [Data](https://github.com/Lak-M/person-name/tree/main/tests/Data). You can get an idea about data sets 
in [Data](https://github.com/Lak-M/person-name/tree/main/tests/Data) directory

    ```php
    const [country name code]_PERSON_NAMES = [
        '[country name code]1' => [
            "country" => [\Lakm\PersonName\Enums\Country::class][required],
            "fullName" => [string][required],
            "firstName" => [string][required],
            "middleName" => [string][optional],
            "lastName" => [string][optional],
            "prefix" => [string][optional],
            "suffix" => [string][optional],
            "formats" => [
                "sorted" => [string][required][optional for countries that not support this],
                "abbreviate" => [array][optional],
            ],
        ],
        '[country name code]2' => [
            ...
        ],
        ...
    ];
    ```
3. Import the data set [here](https://github.com/Lak-M/person-name/blob/main/tests/Data/PersonNames.php). This ensures that the `PersonName` class will be automatically tested against your data [here](https://github.com/Lak-M/person-name/blob/main/tests/Feature/PersonNameTest.php).

4. Write your tests [here](https://github.com/Lak-M/person-name/tree/main/tests/Unit/NameBuilders) and then implement the feature.

