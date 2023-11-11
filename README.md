# Effectra/DataOptimizer PHP Package

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D7.0-8892BF.svg)](https://www.php.net/)

**DataOptimizer** is a PHP package designed to optimize and transform data based on defined rules. It provides a set of classes and interfaces for managing attributes, working with collections, defining data rules, and optimizing data according to those rules.

## Features

- **DataAttribute**: Manage attributes with methods for setting, getting, and manipulating attribute values.

- **DataCollection**: Manipulate and interact with an array of data using various methods.

- **DataRules**: Define validation rules and attributes for data with methods to set rules for different data types.

- **DataOptimizer**: Optimize and transform data based on customizable rules.

## Installation

To install the Data Optimizer PHP package, you can use Composer. Run the following command in your project directory:

```bash
composer require effectra/data-optimizer
```

## Usage

### 1. DataAttribute Class

The `DataAttribute` class provides methods for managing attributes. Here are some examples of how to use it:

#### Set a Single Attribute:

```php
use Effectra\DataOptimizer\DataAttribute;

$dataAttribute = new DataAttribute();
$dataAttribute->setAttribute('name', 'John Doe');
```

#### Set Multiple Attributes:

```php
use Effectra\DataOptimizer\DataAttribute;

$dataAttribute = new DataAttribute();
$dataAttribute->setAttributes(['name' => 'John Doe', 'age' => 25, 'city' => 'New York']);
```

#### Get All Attributes:

```php
use Effectra\DataOptimizer\DataAttribute;

$dataAttribute = new DataAttribute();
$attributes = $dataAttribute->getAttributes();
```

### 2. DataCollection Class

The `DataCollection` class provides various methods to manipulate and interact with an array of data. Here are some examples:

#### Create a Collection:

```php
use Effectra\DataOptimizer\DataCollection;

$dataCollection = new DataCollection([1, 2, 3, 4, 5]);
```

#### Filter the Collection:

```php
use Effectra\DataOptimizer\DataCollection;

$dataCollection = new DataCollection([1, 2, 3, 4, 5]);
$filteredCollection = $dataCollection->filter(fn($item) => $item > 2);
```

#### Map Over the Collection:

```php
use Effectra\DataOptimizer\DataCollection;

$dataCollection = new DataCollection([1, 2, 3, 4, 5]);
$mappedCollection = $dataCollection->map(fn($item) => $item * 2);
```

### 3. DataOptimizer Class

The `DataOptimizer` class is designed for optimizing and transforming data based on defined rules. Here's an example of how to use it:

```php
use Effectra\DataOptimizer\DataOptimizer;

$data = [
    ['name' => 'John Doe', 'age' => '25', 'city' => 'New York'],
    ['name' => 'Jane Doe', 'age' => '30', 'city' => 'San Francisco'],
    // ... more data
];

$optimizer = new DataOptimizer($data);

// Define rules using a callback function
$optimizedData = $optimizer->optimize(function ($rules) {
    $rules->string('name');
    $rules->integer('age');
    $rules->string('city');
});

// $optimizedData now contains the transformed data based on the defined rules
```

### 4. DataRules Class

The `DataRules` class is used for defining validation rules and attributes for data. Here's an example:

```php
use Effectra\DataOptimizer\DataRules;

$rules = new DataRules();

$rules->string('name');
$rules->integer('age');
$rules->string('city');

// Access the defined rules
$definedRules = $rules->getRules();
```

### 5. DataValidator Class

The `DataValidator` class is for validating and processing data. Here's an example:

```php
use Effectra\DataOptimizer\DataValidator;
use Effectra\Database\Exception\DataValidatorException;

$data = [
    ['name' => 'John Doe', 'age' => 25, 'city' => 'New York'],
    ['name' => 'Jane Doe', 'age' => 30, 'city' => 'San Francisco'],
    // ... more data
];

try {
    $validator = new DataValidator($data);
    $validator->isArrayOfAssoc();
    $validator->validate();
} catch (DataValidatorException $e) {
    // Handle validation errors
    echo $e->getMessage();
}
```

## Contributing

If you'd like to contribute to this project, please fork the repository and submit a pull request.

## License

This Data Optimizer PHP package is open-sourced software licensed under the [MIT license](LICENSE).
