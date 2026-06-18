<?php

declare(strict_types=1);

/**
 * Example: Using the new Utility Classes
 *
 * Demonstrates PHP 8.4 features and utility functions.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use GoSuccess\Digistore24\Api\Util\ArrayHelper;
use GoSuccess\Digistore24\Api\Util\TypeConverter;
use GoSuccess\Digistore24\Api\Util\Validator;

echo '=== TypeConverter Examples ===' . PHP_EOL;

// Boolean conversions (Digistore24 format)
var_dump(TypeConverter::toBool('Y'));      // true
var_dump(TypeConverter::toBool('N'));      // false
var_dump(TypeConverter::toBool('1'));      // true
var_dump(TypeConverter::toBool('invalid')); // null

// Date conversions
$date = TypeConverter::toDateTime('2024-01-01 12:00:00');
echo $date?->format('Y-m-d H:i:s') . PHP_EOL;

// Numeric conversions
var_dump(TypeConverter::toInt('123'));     // 123
var_dump(TypeConverter::toFloat('12.34')); // 12.34

echo PHP_EOL . '=== ArrayHelper Examples ===' . PHP_EOL;

$data = [
    'user' => [
        'name' => 'John',
        'address' => [
            'city' => 'Berlin',
        ],
    ],
];

// Dot notation access
echo ArrayHelper::get($data, 'user.address.city', null) . PHP_EOL; // Berlin
echo ArrayHelper::get($data, 'user.phone', 'N/A') . PHP_EOL; // N/A

// Snake case to camelCase conversion
$snakeData = ['first_name' => 'John', 'last_name' => 'Doe'];
$camelData = ArrayHelper::keysToCamelCase($snakeData);
print_r($camelData); // ['firstName' => 'John', 'lastName' => 'Doe']

echo PHP_EOL . '=== Validator Examples ===' . PHP_EOL;

// Email validation
var_dump(Validator::isEmail('test@example.com')); // true
var_dump(Validator::isEmail('invalid'));          // false

// API key validation
var_dump(Validator::isApiKey('123-ABCDEFGHIJ1234567890')); // true
var_dump(Validator::isApiKey('invalid'));                   // false

// Country code validation
var_dump(Validator::isCountryCode('DE')); // true
var_dump(Validator::isCountryCode('de')); // false (must be uppercase)

// Comprehensive validation
$userData = [
    'email' => 'test@example.com',
    'age' => 25,
];

$rules = [
    // Rules per field are either a pipe-delimited string or a list of rule strings.
    'email' => 'required|email',
    'name' => ['required', 'min:2'],
];

$errors = Validator::validate($userData, $rules);
if (! empty($errors)) {
    echo 'Validation errors:' . PHP_EOL;
    print_r($errors);
}

echo PHP_EOL . '=== Property Hooks Example ===' . PHP_EOL;

use GoSuccess\Digistore24\Api\Client\Configuration;

// Configuration with property hooks
$config = new Configuration(
    apiKey: '123-ABCDEFGHIJ1234567890',
);

// Computed property (no method call needed!)
echo 'API URL: ' . $config->apiUrl . PHP_EOL;  // Uses property hook!

// Validation in setters
try {
    $invalidConfig = new Configuration(apiKey: '123-TEST');
    $invalidConfig->timeout = -5;  // Invalid! Will throw exception
} catch (\InvalidArgumentException $e) {
    echo 'Caught expected error: ' . $e->getMessage() . PHP_EOL;
}
