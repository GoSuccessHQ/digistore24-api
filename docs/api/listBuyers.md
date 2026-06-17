# listBuyers

List all buyers in your Digistore24 account.

## Endpoint

```
POST /json/listBuyers
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `limit` | int | No | Maximum number of results (default: 100, max: 1000) |
| `offset` | int | No | Offset for pagination (default: 0) |
| `search` | string | No | Search term for email, name, or company |
| `country` | string | No | Filter by country code (ISO 3166-1 alpha-2) |
| `created_after` | string | No | Filter buyers created after date (Y-m-d H:i:s) |
| `created_before` | string | No | Filter buyers created before date (Y-m-d H:i:s) |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'buyers' => [
            [
                'buyer_id' => 12345,
                'email' => 'buyer1@example.com',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'company' => 'Acme Corp',
                'country' => 'DE',
                'created_at' => '2024-01-15 10:30:00',
                'total_purchases' => 5,
                'total_amount' => 499.95
            ],
            // ... more buyers
        ],
        'total' => 250,
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

// List all buyers
$response = $api->buyers->listBuyers(
    limit: 50,
    offset: 0
);

foreach ($response->buyers as $buyer) {
    echo "{$buyer->email}: {$buyer->totalPurchases} purchases\n";
}

// Search for specific buyers
$response = $api->buyers->listBuyers(
    search: 'john@example.com',
    limit: 10
);

// Filter by country and date
$response = $api->buyers->listBuyers(
    country: 'DE',
    createdAfter: '2025-01-01 00:00:00',
    limit: 100
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid limit, offset, or date format |
| 403 | Access denied | Not authorized to list buyers |

## Notes

- Use pagination for large result sets
- Search supports email, name, and company fields
- Results are ordered by creation date (newest first)
- Maximum 1000 results per request
