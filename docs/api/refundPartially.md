# refundPartially

Partially refund a purchase amount.

## Description

Refunds a partial amount of a payment without changing the order status. The refund amount is treated as a discount applied to the purchase.

This is useful when you want to:
- Give a partial refund for incomplete service
- Apply a discount after purchase
- Refund part of a payment while keeping the order active
- Compensate customers for issues without canceling their access

**Important differences from full refund:**
- Order status does NOT change
- Customer retains access to products/services
- Only a portion of the payment is refunded
- Refund is treated as a discount, not a cancellation

## OpenAPI Specification

[View OpenAPI Specification](https://digistore24.com/api/docs/paths/refundPartially.yaml)

## Request

### Parameters

- `purchaseId` (string, required): The purchase ID to refund
- `amount` (float, required): The amount to refund (must not exceed the payment amount)

### Example Request

```php
use GoSuccess\Digistore24\Digistore24;
use GoSuccess\Digistore24\Request\Purchase\RefundPartiallyRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

$request = new RefundPartiallyRequest(
    purchaseId: 'ABC123',
    amount: 15.00  // Refund €15.00
);

$response = $client->purchases()->refundPartially($request);

if ($response->wasSuccessful()) {
    echo "Partial refund successful!";
} else {
    echo "Refund result: " . $response->getResult();
}
```

## Response

### Response Object

The response contains:

- `result` (string): Result status of the refund operation
- `data` (array): Additional response data

### Response Methods

```php
// Get result status
$result = $response->getResult();

// Get additional data
$data = $response->getData();

// Check if successful
if ($response->wasSuccessful()) {
    echo "Refund processed successfully";
}
```

### Example Response

```json
{
  "api_version": "1.0",
  "current_time": "2024-01-15T10:30:00Z",
  "runtime_seconds": 0.123,
  "result": "success",
  "data": {}
}
```

## Use Cases

### 1. Service Issue Compensation

Compensate customer for service issues:

```php
use GoSuccess\Digistore24\Digistore24;
use GoSuccess\Digistore24\Request\Purchase\RefundPartiallyRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

// Customer experienced 2 days of downtime in monthly subscription
$monthlyPrice = 29.99;
$dailyPrice = $monthlyPrice / 30;
$refundAmount = $dailyPrice * 2;

$request = new RefundPartiallyRequest(
    purchaseId: 'SUB456',
    amount: round($refundAmount, 2)
);

try {
    $response = $client->purchases()->refundPartially($request);
    
    if ($response->wasSuccessful()) {
        echo "Refunded €{$refundAmount} for service downtime\n";
        // Send notification to customer
    }
} catch (\Exception $e) {
    echo "Refund failed: " . $e->getMessage();
}
```

### 2. Post-Purchase Discount

Apply a discount after purchase (e.g., price match):

```php
use GoSuccess\Digistore24\Digistore24;
use GoSuccess\Digistore24\Request\Purchase\RefundPartiallyRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

// Customer found lower price, honor price match guarantee
$originalPrice = 99.00;
$competitorPrice = 79.00;
$difference = $originalPrice - $competitorPrice;

$request = new RefundPartiallyRequest(
    purchaseId: 'ORDER789',
    amount: $difference
);

$response = $client->purchases()->refundPartially($request);

if ($response->wasSuccessful()) {
    echo "Price matched! Refunded €{$difference}";
}
```

### 3. Loyalty Reward

Reward loyal customers with partial refund:

```php
use GoSuccess\Digistore24\Digistore24;
use GoSuccess\Digistore24\Request\Purchase\RefundPartiallyRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

// 10% loyalty cashback for repeat customer
$purchaseAmount = 149.00;
$cashbackPercent = 10;
$cashbackAmount = ($purchaseAmount * $cashbackPercent) / 100;

$request = new RefundPartiallyRequest(
    purchaseId: 'LOYAL123',
    amount: $cashbackAmount
);

$response = $client->purchases()->refundPartially($request);

if ($response->wasSuccessful()) {
    echo "Loyalty reward: €{$cashbackAmount} cashback applied!";
}
```

### 4. Prorated Refund for Canceled Features

Refund for features removed mid-billing cycle:

```php
use GoSuccess\Digistore24\Digistore24;
use GoSuccess\Digistore24\Request\Purchase\RefundPartiallyRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

// Customer downgraded from Pro to Basic mid-month
$proPriceMonthly = 49.99;
$basicPriceMonthly = 19.99;
$daysRemaining = 15;
$daysInMonth = 30;

$proratedDifference = (($proPriceMonthly - $basicPriceMonthly) / $daysInMonth) * $daysRemaining;

$request = new RefundPartiallyRequest(
    purchaseId: 'PRO555',
    amount: round($proratedDifference, 2)
);

$response = $client->purchases()->refundPartially($request);
```

### 5. Bulk Partial Refunds

Process multiple partial refunds:

```php
use GoSuccess\Digistore24\Digistore24;
use GoSuccess\Digistore24\Request\Purchase\RefundPartiallyRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

$refunds = [
    ['purchase_id' => 'ABC123', 'amount' => 10.00],
    ['purchase_id' => 'DEF456', 'amount' => 15.50],
    ['purchase_id' => 'GHI789', 'amount' => 5.99],
];

$successful = 0;
$failed = 0;

foreach ($refunds as $refund) {
    try {
        $request = new RefundPartiallyRequest(
            purchaseId: $refund['purchase_id'],
            amount: $refund['amount']
        );
        
        $response = $client->purchases()->refundPartially($request);
        
        if ($response->wasSuccessful()) {
            $successful++;
            echo "✓ Refunded €{$refund['amount']} to {$refund['purchase_id']}\n";
        } else {
            $failed++;
            echo "✗ Failed to refund {$refund['purchase_id']}\n";
        }
        
        // Rate limiting: Wait between requests
        usleep(500000); // 0.5 second delay
        
    } catch (\Exception $e) {
        $failed++;
        echo "✗ Error refunding {$refund['purchase_id']}: {$e->getMessage()}\n";
    }
}

echo "\nSummary: {$successful} successful, {$failed} failed\n";
```

### 6. Customer Complaint Resolution

Handle customer complaints with partial refunds:

```php
use GoSuccess\Digistore24\Digistore24;
use GoSuccess\Digistore24\Request\Purchase\RefundPartiallyRequest;
use GoSuccess\Digistore24\Request\Purchase\GetPurchaseRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

function resolveComplaint(
    Digistore24 $client,
    string $purchaseId,
    int $satisfactionPercent
): void {
    // Get purchase details first
    $getPurchaseRequest = new GetPurchaseRequest($purchaseId);
    $purchase = $client->purchases()->get($getPurchaseRequest);
    
    $purchaseAmount = $purchase->getAmount();
    
    // Refund based on satisfaction level
    // 100% satisfied = no refund
    // 0% satisfied = full refund (use full refund endpoint instead)
    // 50% satisfied = 50% partial refund
    
    if ($satisfactionPercent < 100 && $satisfactionPercent > 0) {
        $refundPercent = 100 - $satisfactionPercent;
        $refundAmount = ($purchaseAmount * $refundPercent) / 100;
        
        $request = new RefundPartiallyRequest(
            purchaseId: $purchaseId,
            amount: round($refundAmount, 2)
        );
        
        $response = $client->purchases()->refundPartially($request);
        
        if ($response->wasSuccessful()) {
            echo "Partial refund of {$refundPercent}% (€{$refundAmount}) processed\n";
            echo "Customer retains access to product\n";
        }
    }
}

// Example usage
resolveComplaint($client, 'COMPLAINT999', 70); // 30% refund
```

## Error Handling

```php
use GoSuccess\Digistore24\Digistore24;
use GoSuccess\Digistore24\Request\Purchase\RefundPartiallyRequest;
use GoSuccess\Digistore24\Exception\ApiException;
use GoSuccess\Digistore24\Exception\ValidationException;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

try {
    $request = new RefundPartiallyRequest(
        purchaseId: 'ABC123',
        amount: 25.00
    );
    
    $response = $client->purchases()->refundPartially($request);
    
    if ($response->wasSuccessful()) {
        echo "✓ Partial refund successful\n";
        echo "Result: " . $response->getResult() . "\n";
    } else {
        echo "⚠ Refund processed but with unexpected result\n";
        echo "Result: " . $response->getResult() . "\n";
        print_r($response->getData());
    }
    
} catch (ValidationException $e) {
    echo "Validation error: " . $e->getMessage() . "\n";
    echo "Check:\n";
    echo "- Purchase ID is valid\n";
    echo "- Refund amount does not exceed payment amount\n";
    echo "- Amount is positive\n";
    
} catch (ApiException $e) {
    echo "API error: " . $e->getMessage() . "\n";
    echo "Status code: " . $e->getCode() . "\n";
}
```

## Important Notes

- **Order Status Unchanged**: The order status does NOT change with partial refunds. Customer retains access.
- **Amount Limit**: Refund amount must not exceed the original payment amount
- **Discount Treatment**: Partial refunds are treated as discounts, not cancellations
- **Full Refunds**: For complete refunds that cancel the order, use `PurchaseResource::refund()` instead
- **Multiple Partial Refunds**: You can issue multiple partial refunds for the same purchase
- **Customer Notification**: Customers receive email notifications about partial refunds
- **Accounting**: Partial refunds are properly tracked in financial reports

## Comparison: Partial vs Full Refund

| Feature | Partial Refund | Full Refund |
|---------|---------------|-------------|
| **Order Status** | Unchanged | Changed to refunded |
| **Customer Access** | Retained | Revoked |
| **Use Case** | Discount, compensation | Cancellation |
| **Amount** | Portion of payment | Entire payment |
| **Endpoint** | `refundPartially` | `refundPurchase` |

## Related Endpoints

- [refundPurchase](refundPurchase.md) - Fully refund a purchase
- [createBillingOnDemand](createBillingOnDemand.md) - Create on-demand billing
- [getPurchase](getPurchase.md) - Get purchase details
- [updatePurchase](updatePurchase.md) - Update purchase information

## See Also

- [Billing API Documentation](https://digistore24.com/api/docs#tag/Billing)
- [Refund Policy Guide](https://digistore24.com/guide/refunds)
- [Customer Service Best Practices](https://digistore24.com/guide/customer-service)
