<?php

declare(strict_types=1);

/**
 * Example: Basic usage of the Digistore24 API Client
 *
 * This example shows the recommended way to use the API through resource layers.
 * Resources automatically handle HTTP methods, request/response types, and validation.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Request\Product\GetProductRequest;

// Create configuration
$config = new Configuration(
    apiKey: 'YOUR-API-KEY-HERE',
);

// Create Digistore24 client
$ds24 = new Digistore24($config);

// Example 1: Get user information
echo "=== Get User Info ===\n";

try {
    $response = $ds24->users->getInfo();

    $userInfo = $response->userInfo;
    echo "User ID: {$userInfo['user_id']}\n";
    echo "User Name: {$userInfo['user_name']}\n";
    echo "Permissions: {$userInfo['api_key_permissions']}\n\n";

} catch (\GoSuccess\Digistore24\Api\Exception\ApiException $e) {
    echo "Error: {$e->getMessage()}\n\n";
}

// Example 2: List products
echo "=== List Products ===\n";

try {
    $response = $ds24->products->list();

    echo "Found {$response->totalCount} products:\n";
    foreach ($response->products as $product) {
        echo "- [{$product->id}] {$product->name}\n";
    }
    echo "\n";

} catch (\GoSuccess\Digistore24\Api\Exception\ApiException $e) {
    echo "Error: {$e->getMessage()}\n\n";
}// Example 3: Get specific product
echo "=== Get Product Details ===\n";

try {
    $request = new GetProductRequest(productId: '12345');
    $product = $ds24->products->get($request);

    echo "Product: {$product->name} (ID: {$product->id})\n";
    echo "Currency: {$product->currency}\n";
    echo 'Active: ' . ($product->isActive ? 'Yes' : 'No') . "\n\n";

} catch (\GoSuccess\Digistore24\Api\Exception\NotFoundException $e) {
    echo "Product not found!\n\n";
} catch (\GoSuccess\Digistore24\Api\Exception\ApiException $e) {
    echo "Error: {$e->getMessage()}\n\n";
}

// Example 4: List countries
echo "=== List Countries ===\n";

try {
    $response = $ds24->countries->listCountries();

    $countries = $response->countries;
    echo 'Available countries: ' . count($countries) . "\n";
    // Show first 5
    $countriesToShow = array_slice($countries, 0, 5, true);
    foreach ($countriesToShow as $country) {
        echo "- {$country->code}: {$country->name}\n";
    }
    echo "...\n\n";

} catch (\GoSuccess\Digistore24\Api\Exception\ApiException $e) {
    echo "Error: {$e->getMessage()}\n\n";
}echo "=== Examples completed! ===\n";
echo "\nNote: Resources automatically handle:\n";
echo "- Correct HTTP methods (GET for list/get, POST for create, etc.)\n";
echo "- Request/response type conversion\n";
echo "- Validation and error handling\n";
echo "- URL construction\n";
