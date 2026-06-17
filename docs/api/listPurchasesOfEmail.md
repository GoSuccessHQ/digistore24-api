# listPurchasesOfEmail

List all purchases belonging to a specific email address.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listPurchasesOfEmail`

## OpenAPI Specification

[View OpenAPI Spec](https://digistore24.com/api/docs/paths/listPurchasesOfEmail.yaml)

## Parameters

### Required Parameters

- `email` (string) - The buyer's email address (must be valid email format)

### Optional Parameters

- `limit` (integer) - Maximum number of purchases to show (default: 100, minimum: 1)

## Response

```json
[
  {
    "id": "ABCD-1234-EFGH",
    "created_at": "2024-01-15 10:30:00",
    "amount": 99.00,
    "currency": "EUR",
    "status": "completed"
  },
  {
    "id": "WXYZ-5678-IJKL",
    "created_at": "2024-03-20 14:45:00",
    "amount": 49.00,
    "currency": "USD",
    "status": "active"
  }
]
```

### Response Fields

- `id` (string) - Purchase ID
- `created_at` (string) - Purchase creation timestamp
- `amount` (float) - Purchase amount
- `currency` (string) - Purchase currency
- `status` (string) - Purchase status

## Usage Example

```php
use Digistore24\Request\Purchase\ListPurchasesOfEmailRequest;

$request = new ListPurchasesOfEmailRequest(
    email: 'customer@example.com'
);

try {
    $response = $digistore24->purchases->listByEmail($request);
    
    foreach ($response->purchases as $purchase) {
        echo "Purchase ID: {$purchase->id}\n";
        echo "Amount: {$purchase->amount} {$purchase->currency}\n";
        echo "Created: {$purchase->createdAt}\n";
        echo "Status: {$purchase->status}\n\n";
    }
    
    echo "Total purchases: " . count($response->purchases);
} catch (\Digistore24\Exception\ApiException $e) {
    echo "Error: " . $e->getMessage();
}
```

## Limit Results

```php
$request = new ListPurchasesOfEmailRequest(
    email: 'customer@example.com',
    limit: 10 // Only return 10 most recent purchases
);

$response = $digistore24->purchases->listByEmail($request);
echo "Found " . count($response->purchases) . " purchases";
```

## Check Customer History

```php
$request = new ListPurchasesOfEmailRequest(
    email: 'potential-customer@example.com'
);

$response = $digistore24->purchases->listByEmail($request);

if (empty($response->purchases)) {
    echo "New customer - no previous purchases";
} else {
    echo "Returning customer with " . count($response->purchases) . " purchases";
    
    // Calculate total spent
    $totalSpent = 0;
    foreach ($response->purchases as $purchase) {
        if ($purchase->currency === 'EUR') {
            $totalSpent += $purchase->amount;
        }
    }
    echo "Total spent: €{$totalSpent}";
}
```

## Filter Active Subscriptions

```php
$request = new ListPurchasesOfEmailRequest(
    email: 'subscriber@example.com'
);

$response = $digistore24->purchases->listByEmail($request);

$activeSubscriptions = array_filter(
    $response->purchases,
    fn($purchase) => $purchase->status === 'active'
);

echo "Active subscriptions: " . count($activeSubscriptions);
```

## Customer Support Lookup

```php
function getCustomerPurchases(string $email): array
{
    global $digistore24;
    
    $request = new ListPurchasesOfEmailRequest(email: $email);
    $response = $digistore24->purchases->listByEmail($request);
    
    $purchases = [];
    foreach ($response->purchases as $purchase) {
        $purchases[] = [
            'id' => $purchase->id,
            'date' => $purchase->createdAt,
            'amount' => number_format($purchase->amount, 2),
            'currency' => $purchase->currency,
            'status' => $purchase->status,
        ];
    }
    
    return $purchases;
}

// In your support system
$customerEmail = 'support-inquiry@example.com';
$purchases = getCustomerPurchases($customerEmail);

if (!empty($purchases)) {
    echo "Customer purchase history:\n";
    foreach ($purchases as $purchase) {
        echo "- {$purchase['date']}: {$purchase['currency']} {$purchase['amount']} ({$purchase['status']})\n";
    }
}
```

## Email Validation Check

```php
use Digistore24\Exception\ValidationException;

try {
    $request = new ListPurchasesOfEmailRequest(
        email: 'invalid-email' // Will throw validation error
    );
    $response = $digistore24->purchases->listByEmail($request);
} catch (ValidationException $e) {
    echo "Invalid email format: " . $e->getMessage();
}
```

## Batch Email Lookup

```php
$customerEmails = [
    'customer1@example.com',
    'customer2@example.com',
    'customer3@example.com',
];

$results = [];

foreach ($customerEmails as $email) {
    try {
        $request = new ListPurchasesOfEmailRequest(email: $email);
        $response = $digistore24->purchases->listByEmail($request);
        
        $results[$email] = [
            'count' => count($response->purchases),
            'purchases' => $response->purchases,
        ];
    } catch (\Digistore24\Exception\ApiException $e) {
        $results[$email] = [
            'error' => $e->getMessage(),
        ];
    }
}

// Display summary
foreach ($results as $email => $data) {
    if (isset($data['error'])) {
        echo "{$email}: Error - {$data['error']}\n";
    } else {
        echo "{$email}: {$data['count']} purchases\n";
    }
}
```

## Error Handling

```php
use Digistore24\Exception\ValidationException;
use Digistore24\Exception\ApiException;

try {
    $request = new ListPurchasesOfEmailRequest(
        email: 'customer@example.com',
        limit: 50
    );
    $response = $digistore24->purchases->listByEmail($request);
    
    echo "Found " . count($response->purchases) . " purchases";
} catch (ValidationException $e) {
    // Invalid email format or limit < 1
    echo "Validation error: " . $e->getMessage();
} catch (ApiException $e) {
    // General API error
    echo "API error: " . $e->getMessage();
}
```

## Important Notes

- **Email Format**: The email parameter must be a valid email address format
- **Limit Range**: Limit must be at least 1, default is 100
- **Privacy**: This endpoint requires proper API authentication
- **Use Cases**: Perfect for customer support, duplicate prevention, subscription management
- **Performance**: Use limit parameter to avoid retrieving large result sets
- **Empty Results**: Returns empty array if email has no purchases
- **Case Sensitivity**: Email addresses are typically case-insensitive

## Related Endpoints

- [getPurchase](getPurchase.md) - Get detailed information about a specific purchase
- [listPurchases](listPurchases.md) - List all purchases with advanced filtering
- [createAddonChangePurchase](createAddonChangePurchase.md) - Modify purchase addons
- [getPurchaseTracking](getPurchaseTracking.md) - Get tracking information for purchases
