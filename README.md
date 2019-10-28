[![Build Status](https://travis-ci.org/mkakpabla/form-validation-php.svg?branch=master)](https://travis-ci.org/mkakpabla/form-validation-php)
# Zen Validation - PHP Validation Library

## Features

* API like Laravel validation.
* Array validation.
* Custom validation messages.

## Requirements

* PHP 7.2 or higher
* Composer for installation

## Quick Start

#### Installation

```bash
composer require "mkakpabla/validation"
```

#### Usage

Examples :

```php
<?php

require 'vendor/autoload.php';

use Zen\Validation\Validator;

$validator = new Validator([], [
  'title' => 'required|notEmpty',
  'slug' => 'required|slug',
  'content' => 'required|text'
  ]);

$validator->validate();

if(!$validator->isValid()) {
  var_dump($validator->errors());
} else {
  
  // Formulaire valide
  // Traitements
}
```
 
#### Custom Messages for Validator
```php
<?php

require 'vendor/autoload.php';

use Zen\Validation\Validator;
$validator = new Validator($data, [
  'title'  => 'required',
  ]);
$validator->addErrorsMessages([
  'title.required' => "le titre est obligatoire"
]);
$validator->validate();
````

## Validation Rules

 * `required` - Field is required
 * `email` - Field must be email
 * `notEmpty` - Field did not be empty
 * `alpha` - Content of field must be alphabetic
 * `alphaNum` - Content of field must be alphanumeric
 * `integer` - Must be integer number
 * `text` - Field must be a text
 * `datetime` - Field must be a datetime
 * `time` - Field must be a time
 * `date` - Field must be a date
 * `slug` - Field must be a slug
 * `confirm` - Field must be a same as another field
 * `min:number` - The field under this rule must have a size biger or equal than the given number
 * `max:number` - The field under this rule must have a size lower or equal than the given number
 * `between:min,max` - The field under this rule must have a size between min and max params 
 





