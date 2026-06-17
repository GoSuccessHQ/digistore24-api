# reportFraud

Report fraudulent activity to Digistore24.

## Endpoint

```
POST /json/reportFraud
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `purchase_id` | string | Yes | Purchase ID to report as fraudulent |
| `reason` | string | No | Reason for fraud report |
| `details` | string | No | Additional details about the fraud |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'message' => 'Fraud report submitted successfully',
        'purchase_id' => '12345',
        'status' => 'reported'
    ]
]
```

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$api = new Digistore24($config);

// Report a fraudulent purchase
$response = $api->fraud->reportFraud(
    purchaseId: 'ABC123',
    reason: 'Chargeback fraud',
    details: 'Customer initiated chargeback immediately after delivery'
);

if ($response->result === 'success') {
    echo "Fraud reported for purchase: " . $response->purchaseId;
}
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid purchase ID | The provided purchase ID is invalid |
| 404 | Purchase not found | Purchase does not exist |
| 403 | Access denied | Not authorized to report fraud for this purchase |

## Notes

- Fraud reports help protect the Digistore24 ecosystem
- Reports are reviewed by Digistore24 staff
- False reports may result in API access restrictions
