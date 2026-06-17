# listVouchers

List all vouchers in your Digistore24 account.

## Endpoint

```
POST /json/listVouchers
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `limit` | int | No | Maximum number of results (default: 100, max: 1000) |
| `offset` | int | No | Offset for pagination (default: 0) |
| `active_only` | bool | No | Filter for active vouchers only |
| `product_id` | int | No | Filter by product ID |
| `search` | string | No | Search term for voucher code |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'vouchers' => [
            [
                'voucher_id' => 789,
                'code' => 'SUMMER2025',
                'discount_type' => 'percentage',
                'discount_value' => 20.0,
                'valid_from' => '2025-06-01 00:00:00',
                'valid_until' => '2025-08-31 23:59:59',
                'max_uses' => 100,
                'uses' => 45,
                'is_active' => true
            ],
            // ... more vouchers
        ],
        'total' => 25,
        'limit' => 100,
        'offset' => 0
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

// List all vouchers
$response = $api->vouchers->listVouchers(
    limit: 50
);

foreach ($response->vouchers as $voucher) {
    echo "{$voucher->code}: {$voucher->uses}/{$voucher->maxUses} uses\n";
}

// List only active vouchers
$response = $api->vouchers->listVouchers(
    activeOnly: true,
    limit: 100
);

// Search for specific voucher
$response = $api->vouchers->listVouchers(
    search: 'SUMMER'
);

// Filter by product
$response = $api->vouchers->listVouchers(
    productId: 123
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid limit or offset |
| 403 | Access denied | Not authorized to list vouchers |

## Notes

- Results are ordered by creation date (newest first)
- Use pagination for large result sets
- Active vouchers are within valid date range and not expired
- Maximum 1000 results per request
