# listMarketplaceEntries

List all marketplace entries.

## Endpoint

```
POST /json/listMarketplaceEntries
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `category` | string | No | Filter by category |
| `is_active` | bool | No | Filter by active status |
| `limit` | int | No | Number of results (default: 100, max: 500) |
| `offset` | int | No | Offset for pagination |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'entries' => [
            [
                'entry_id' => 123,
                'product_id' => 12345,
                'title' => 'My Product',
                'category' => 'Software',
                'price' => 99.99,
                'is_active' => true,
                'views' => 1500,
                'sales' => 45,
                'rating' => 4.5
            ],
            // ... more entries
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

// List all entries
$response = $api->marketplace->listMarketplaceEntries();

foreach ($response->entries as $entry) {
    echo "{$entry->title}: {$entry->sales} sales\n";
}

// Filter by category
$response = $api->marketplace->listMarketplaceEntries(
    category: 'Software',
    limit: 50
);

// List only active entries
$response = $api->marketplace->listMarketplaceEntries(
    isActive: true
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid category or limit |

## Notes

- Results ordered by creation date (newest first)
- Use for managing marketplace presence
- Maximum 500 results per request
- Categories include: Software, Education, Business, Health, etc.
