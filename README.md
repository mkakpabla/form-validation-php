# Zen Validator
Zen Validator is a simple PHP validation library

## Usage
To use it we create a new validation instance which takes into account the validation rules which is an array. Here is an exemple
```php
$validator = new Validator([
  'email'  => 'required|email',
  'title' => 'required|notEmpty'
  ]);
```
After:
```php
$data = [];
$validator->validate($data)
```
We will have in our example above a table containing two errors

## Validation Rules

 * `required` - Field is required
 * `email` - Field must be a email
 * `notEmpty` - Field did not be empty
 * `alpha` - Content of field must be alphabetic
 * `integer` - Must be integer number
 * `text` - Field must be a text
 * `length` - Verify the length of field value
