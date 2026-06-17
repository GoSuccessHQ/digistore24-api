# createBillingOnDemand

Create a billing on demand order using a reference purchase's payment method.

## Description

Creates a customized order that automatically uses the payment method from a reference purchase. This allows you to create new orders without requiring the customer to re-enter their payment details, making it ideal for:

- Upselling to existing customers
- Adding services or products to previous purchases
- Creating subscription-like billing for one-time purchases
- Automated recurring billing scenarios

The customer's stored payment method is automatically charged for the new order.

## Requirements

- **"Billing on demand" right must be enabled** for your vendor account in Digistore24 settings
- Reference purchase must have been made with a **payment method that supports rebilling** (e.g., credit card, direct debit)

## OpenAPI Specification

[View OpenAPI Specification](https://digistore24.com/api/docs/paths/createBillingOnDemand.yaml)

## Request

### Parameters

#### Required Parameters

- `purchaseId` (string): The reference order ID. Must have been made with a rebilling-capable payment method.
- `productId` (string): The product ID in Digistore24 to bill for.

#### Optional Parameters

- `paymentPlan` (array): Payment plan configuration
  - `first_amount` (number): Purchase price or first payment amount
  - `other_amounts` (number): Amount of follow-up payments for subscriptions/installments
  - `currency` (string): Three-character currency code (e.g., "EUR", "USD")
  - `number_of_installments` (integer): Number of payments including the first
  - `first_billing_interval` (string): Time between purchase and second installment (e.g., "1_month")
  - `other_billing_intervals` (string): Time interval for second and further payments
  - `test_interval` (string): Test interval before payment starts
  - `template` (string): ID of payment method used as template
  - `upgrade_type` (string): Type of upgrade handling ("upgrade" or "downgrade")

- `tracking` (array): Tracking data
  - `custom` (string): Custom value for order reference
  - `affiliate` (string): Affiliate's Digistore24 ID
  - `campaignkey` (string): Campaign key of the affiliate
  - `trackingkey` (string): Vendor's tracking key

- `placeholders` (array): Key-value pairs for product title and description placeholders

- `settings` (array): Additional order settings
  - `voucher_code` (string): Voucher to apply at payment
  - `quantity` (integer): Quantity of the main product (default: 1)
  - `product_country` (string): Two-letter country code for the product

- `addons` (array): List of add-on products, each with:
  - `product_id` (string): Product ID of the addon
  - `first_amount` (number): First payment amount for subscription/installment
  - `other_amounts` (number): Follow-up payment amounts
  - `single_amount` (number): Purchase amount for single payments
  - `quantity` (integer): Quantity of the addon (default: 1)
  - `currency` (string): Three-character currency code
  - `is_quantity_editable_after_purchase` (string): "Y" or "N" (default: "N")
  - `product_country` (string): Two-letter country code

### Example Request

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Billing\CreateBillingOnDemandRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

// Simple billing with reference purchase
$request = new CreateBillingOnDemandRequest(
    purchaseId: 'QWERTY123',
    productId: '12345'
);

$response = $client->billing->createOnDemand($request);

echo "Created purchase: " . $response->createdPurchaseId . "\n";
echo "Payment status: " . $response->paymentStatusMsg . "\n";
```

### Advanced Example with Payment Plan

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Billing\CreateBillingOnDemandRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

// Create subscription-like billing
$request = new CreateBillingOnDemandRequest(
    purchaseId: 'QWERTY123',
    productId: '12345',
    paymentPlan: [
        'first_amount' => 99.00,
        'other_amounts' => 29.99,
        'currency' => 'EUR',
        'number_of_installments' => 12,
        'other_billing_intervals' => '1_month',
    ],
    tracking: [
        'custom' => 'upsell-campaign-2024',
        'affiliate' => 'AFF123',
    ],
    settings: [
        'quantity' => 1,
        'voucher_code' => 'UPGRADE20',
    ]
);

$response = $client->billing->createOnDemand($request);
```

## Response

### Response Object

The response contains information about the created order:

- `createdPurchaseId` (string): The ID of the newly created order
- `paymentStatus` (string): Payment status code
- `paymentStatusMsg` (string): Payment status in readable form
- `billingStatus` (string): Billing/order status code
- `billingStatusMsg` (string): Order status in readable form

### Response Methods

```php
// Get created purchase ID
$purchaseId = $response->createdPurchaseId;

// Get payment status
$status = $response->paymentStatus;
$statusMsg = $response->paymentStatusMsg;

// Get billing status
$billingStatus = $response->billingStatus;
$billingMsg = $response->billingStatusMsg;

// Check if successful
if ($response->wasSuccessful()) {
    echo "Billing successful!";
}
```

### Example Response

```json
{
  "created_purchase_id": "NEWORDER789",
  "payment_status": "paid",
  "payment_status_msg": "Payment completed successfully",
  "billing_status": "completed",
  "billing_status_msg": "Order completed"
}
```

## Use Cases

### 1. Upsell to Existing Customers

Offer additional products to customers who already purchased:

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Billing\CreateBillingOnDemandRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

// Customer bought basic course, offer advanced course
$request = new CreateBillingOnDemandRequest(
    purchaseId: 'BASIC123',  // Their original purchase
    productId: '67890',      // Advanced course product ID
    tracking: [
        'custom' => 'upsell-advanced-course',
    ]
);

try {
    $response = $client->billing->createOnDemand($request);
    
    if ($response->wasSuccessful()) {
        echo "Upsell successful! New purchase: " . $response->createdPurchaseId;
        // Send confirmation email, grant access, etc.
    } else {
        echo "Billing status: " . $response->billingStatusMsg;
    }
} catch (\Exception $e) {
    echo "Upsell failed: " . $e->getMessage();
}
```

### 2. Subscription-Style Billing

Create recurring billing for a one-time purchase:

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Billing\CreateBillingOnDemandRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

// Create monthly subscription billing
$request = new CreateBillingOnDemandRequest(
    purchaseId: 'INITIAL456',
    productId: '11111',  // Monthly membership product
    paymentPlan: [
        'first_amount' => 0.00,      // First month free
        'other_amounts' => 29.99,    // €29.99/month thereafter
        'currency' => 'EUR',
        'number_of_installments' => 12,
        'first_billing_interval' => '1_month',
        'other_billing_intervals' => '1_month',
    ],
    tracking: [
        'custom' => 'trial-conversion',
    ]
);

$response = $client->billing->createOnDemand($request);
```

### 3. Add-on Products

Bill for additional products with main product:

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Billing\CreateBillingOnDemandRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

$request = new CreateBillingOnDemandRequest(
    purchaseId: 'MAIN789',
    productId: '22222',  // Main product
    addons: [
        [
            'product_id' => '22223',
            'single_amount' => 19.99,
            'quantity' => 1,
            'currency' => 'EUR',
        ],
        [
            'product_id' => '22224',
            'single_amount' => 9.99,
            'quantity' => 2,
            'currency' => 'EUR',
        ],
    ]
);

$response = $client->billing->createOnDemand($request);
echo "Total order created: " . $response->createdPurchaseId;
```

### 4. Automated Service Billing

Automatically bill for usage-based services:

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Billing\CreateBillingOnDemandRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

// Calculate usage for the month
$apiCalls = 15000;
$costPerThousand = 2.50;
$totalAmount = ($apiCalls / 1000) * $costPerThousand;

$request = new CreateBillingOnDemandRequest(
    purchaseId: 'CUSTOMER999',
    productId: '33333',  // API usage product
    paymentPlan: [
        'first_amount' => $totalAmount,
        'currency' => 'USD',
    ],
    tracking: [
        'custom' => "usage-{$apiCalls}-calls",
    ],
    placeholders: [
        'usage_count' => (string)$apiCalls,
        'period' => date('F Y'),
    ]
);

$response = $client->billing->createOnDemand($request);
```

### 5. Voucher/Discount Application

Apply vouchers to on-demand billing:

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Billing\CreateBillingOnDemandRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

$request = new CreateBillingOnDemandRequest(
    purchaseId: 'LOYAL100',
    productId: '44444',
    settings: [
        'voucher_code' => 'LOYAL20',  // 20% discount for loyal customer
    ],
    tracking: [
        'custom' => 'loyalty-program',
    ]
);

$response = $client->billing->createOnDemand($request);
```

## Error Handling

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Billing\CreateBillingOnDemandRequest;
use GoSuccess\Digistore24\Api\Exception\ForbiddenException;
use GoSuccess\Digistore24\Api\Exception\ApiException;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

try {
    $request = new CreateBillingOnDemandRequest(
        purchaseId: 'REF123',
        productId: '55555'
    );
    
    $response = $client->billing->createOnDemand($request);
    
    if ($response->wasSuccessful()) {
        echo "✓ Billing successful!\n";
        echo "Purchase ID: " . $response->createdPurchaseId . "\n";
    } else {
        echo "⚠ Billing incomplete\n";
        echo "Status: " . $response->billingStatusMsg . "\n";
    }
    
} catch (ForbiddenException $e) {
    echo "Access denied. Possible reasons:\n";
    echo "- Billing on demand not enabled for your account\n";
    echo "- Insufficient API permissions\n";
    echo "Error: " . $e->getMessage() . "\n";
    
} catch (ApiException $e) {
    echo "API error: " . $e->getMessage() . "\n";
    echo "Possible reasons:\n";
    echo "- Invalid purchase ID\n";
    echo "- Reference purchase doesn't support rebilling\n";
    echo "- Invalid product ID\n";
    echo "- Payment amount exceeds limits\n";
}
```

## Important Notes

- **Billing on Demand Permission**: This feature must be explicitly enabled in your Digistore24 vendor settings
- **Payment Method Compatibility**: The reference purchase must use a payment method that supports rebilling (credit card, direct debit, PayPal subscription, etc.)
- **Customer Notification**: Customers will receive email notifications for new orders created via billing on demand
- **Refunds**: Orders created via billing on demand can be refunded using standard refund endpoints
- **Testing**: Test thoroughly with test purchases before using in production
- **Rate Limits**: Be aware of API rate limits when creating multiple billing on demand orders

## Related Endpoints

- [refundPartially](refundPartially.md) - Partially refund an order
- [refundPurchase](refundPurchase.md) - Fully refund an order
- [getPurchase](getPurchase.md) - Get purchase details
- [createRebillingPayment](createRebillingPayment.md) - Create rebilling payment

## See Also

- [Billing API Documentation](https://digistore24.com/api/docs#tag/Billing)
- [Billing on Demand Guide](https://digistore24.com/guide/billing-on-demand)
- [Payment Methods & Rebilling](https://digistore24.com/guide/payment-methods)
