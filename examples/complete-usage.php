<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\DTO\BuyerData;
use GoSuccess\Digistore24\Api\DTO\PaymentPlanData;
use GoSuccess\Digistore24\Api\DTO\SettingsData;
use GoSuccess\Digistore24\Api\DTO\TrackingData;
use GoSuccess\Digistore24\Api\DTO\UrlsData;
use GoSuccess\Digistore24\Api\Request\BuyUrl\CreateBuyUrlRequest;

/**
 * Example: Complete Digistore24 API Usage
 *
 * Demonstrates the new resource-based architecture with typed requests/responses.
 */

// Initialize the Digistore24 client
$config = new Configuration(
    apiKey: 'YOUR-API-KEY',
);

$ds24 = new Digistore24($config);

// Example 1: Create a simple buy URL
echo "=== Example 1: Simple Buy URL ===\n";
$request = new CreateBuyUrlRequest();
$request->productId = 12345;
$request->validUntil = '48h';

try {
    $response = $ds24->buyUrls->create($request);
    echo "Buy URL created successfully!\n";
    echo "URL: {$response->url}\n";
    echo "Valid until: {$response->validUntil->format('Y-m-d H:i:s')}\n";
    echo "ID: {$response->id}\n\n";
} catch (\GoSuccess\Digistore24\Api\Exception\ApiException $e) {
    echo "Error: {$e->getMessage()}\n";
    echo "Code: {$e->getCode()}\n\n";
}

// Example 2: Create buy URL with pre-filled buyer data
echo "=== Example 2: Buy URL with Buyer Data ===\n";
$request = new CreateBuyUrlRequest();
$request->productId = 12345;
$request->validUntil = '24h';

// Create buyer data with property hooks validation
$buyer = new BuyerData();
$buyer->email = 'customer@example.com';  // Validated automatically
$buyer->firstName = 'John';
$buyer->lastName = 'Doe';
$buyer->country = 'de';  // Auto-uppercased to 'DE'
$buyer->city = 'Berlin';
$buyer->zipcode = '10115';
$buyer->street = 'Alexanderplatz 1';

$request->buyer = $buyer;

try {
    $response = $ds24->buyUrls->create($request);
    echo "Buy URL with buyer data created!\n";
    echo "URL: {$response->url}\n\n";
} catch (\GoSuccess\Digistore24\Api\Exception\ValidationException $e) {
    echo "Validation error: {$e->getMessage()}\n\n";
}

// Example 3: Buy URL with custom payment plan
echo "=== Example 3: Custom Payment Plan ===\n";
$request = new CreateBuyUrlRequest();
$request->productId = 12345;

$paymentPlan = new PaymentPlanData();
$paymentPlan->firstAmount = 9.99;
$paymentPlan->otherAmounts = 29.99;
$paymentPlan->currency = 'eur';  // Auto-uppercased to 'EUR'
$paymentPlan->numberOfInstallments = 12;
$paymentPlan->firstBillingInterval = '1w';
$paymentPlan->otherBillingIntervals = '1m';

$request->paymentPlan = $paymentPlan;

try {
    $response = $ds24->buyUrls->create($request);
    echo "Buy URL with payment plan created!\n";
    echo "URL: {$response->url}\n\n";
} catch (\GoSuccess\Digistore24\Api\Exception\ApiException $e) {
    echo "Error: {$e->getMessage()}\n\n";
}

// Example 4: Buy URL with tracking parameters
echo "=== Example 4: Tracking Parameters ===\n";
$request = new CreateBuyUrlRequest();
$request->productId = 12345;

$tracking = new TrackingData();
$tracking->affiliate = 'partner123';
$tracking->campaignkey = 'summer2024';
$tracking->utmSource = 'newsletter';
$tracking->utmMedium = 'email';
$tracking->utmCampaign = 'product-launch';

$request->tracking = $tracking;

try {
    $response = $ds24->buyUrls->create($request);
    echo "Buy URL with tracking created!\n";
    echo "URL: {$response->url}\n\n";
} catch (\GoSuccess\Digistore24\Api\Exception\ApiException $e) {
    echo "Error: {$e->getMessage()}\n\n";
}

// Example 5: Complete buy URL with all parameters
echo "=== Example 5: Complete Buy URL ===\n";
$request = new CreateBuyUrlRequest();
$request->productId = 12345;
$request->validUntil = '72h';

// Buyer
$buyer = new BuyerData();
$buyer->email = 'vip@example.com';
$buyer->firstName = 'Jane';
$buyer->lastName = 'Smith';
$buyer->company = 'ACME Corp';
$buyer->country = 'us';
$buyer->state = 'CA';
$buyer->city = 'San Francisco';
$buyer->zipcode = '94105';
$buyer->street = 'Market Street 1';
$buyer->phoneNo = '+1-555-0123';
$request->buyer = $buyer;

// Payment Plan
$paymentPlan = new PaymentPlanData();
$paymentPlan->firstAmount = 0.00;  // Trial
$paymentPlan->otherAmounts = 49.99;
$paymentPlan->currency = 'usd';
$paymentPlan->numberOfInstallments = 6;
$paymentPlan->firstBillingInterval = '7d';
$paymentPlan->otherBillingIntervals = '1m';
$request->paymentPlan = $paymentPlan;

// Tracking
$tracking = new TrackingData();
$tracking->affiliate = 'partner456';
$tracking->campaignkey = 'fall2024';
$tracking->utmSource = 'google';
$tracking->utmMedium = 'cpc';
$tracking->utmCampaign = 'brand-awareness';
$tracking->utmTerm = 'saas+software';
$tracking->utmContent = 'ad-variant-a';
$request->tracking = $tracking;

// URLs
$urls = new UrlsData();
$urls->thankyouUrl = 'https://example.com/success';
$urls->fallbackUrl = 'https://example.com/error';
$request->urls = $urls;

// Settings (optional)
$settings = new SettingsData();
$settings->affiliateCommissionRate = 50.0;  // 50% commission
$settings->voucherCode = 'WELCOME10';  // apply a voucher code
$settings->voucherOthRates = 10.0;  // 10% discount on follow-up payments
$request->settings = $settings;

// Placeholders (custom fields)
$request->placeholders = [
    'custom_field_1' => 'Value 1',
    'custom_field_2' => 'Value 2',
];

try {
    $response = $ds24->buyUrls->create($request);
    echo "Complete buy URL created successfully!\n";
    echo "URL: {$response->url}\n";
    echo "Valid until: {$response->validUntil->format('Y-m-d H:i:s')}\n";
    echo "ID: {$response->id}\n\n";
} catch (\GoSuccess\Digistore24\Api\Exception\ApiException $e) {
    echo "Error: {$e->getMessage()}\n";
    echo 'Context: ' . json_encode($e->getContext(), JSON_PRETTY_PRINT) . "\n\n";
}

// Example 6: Error handling
echo "=== Example 6: Error Handling ===\n";

try {
    // Invalid email will be caught by property hook
    $buyer = new BuyerData();
    $buyer->email = 'invalid-email';  // Throws InvalidArgumentException
} catch (\InvalidArgumentException $e) {
    echo "Property validation error: {$e->getMessage()}\n";
}

try {
    // Empty product ID will be caught by property hook
    $request = new CreateBuyUrlRequest();
    $request->productId = '';  // Throws InvalidArgumentException
} catch (\InvalidArgumentException $e) {
    echo "Request validation error: {$e->getMessage()}\n";
}

echo "\n=== All examples completed! ===\n";
