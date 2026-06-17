# getMarketplaceEntry

Get details of a marketplace entry.

## Endpoint

```
POST /json/getMarketplaceEntry
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `entry_id` | int | Yes | Marketplace entry ID |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'entry_id' => 123,
        'product_id' => 12345,
        'title' => 'My Product',
        'description' => 'Product description',
        'category' => 'Software',
        'price' => 99.99,
        'currency' => 'EUR',
        'is_active' => true,
        'views' => 1500,
        'sales' => 45,
        'rating' => 4.5,
        'reviews_count' => 12,
        'created_at' => '2025-01-15 10:00:00'
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

// Get marketplace entry
$response = $api->marketplace->getMarketplaceEntry(
    entryId: 123
);

echo "Product: {$response->title}\n";
echo "Views: {$response->views}\n";
echo "Sales: {$response->sales}\n";
echo "Rating: {$response->rating}/5 ({$response->reviewsCount} reviews)\n";
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 404 | Entry not found | Marketplace entry does not exist |
| 403 | Access denied | Not authorized to access this entry |

## Notes

- Returns detailed marketplace performance metrics
- Rating is average of all customer reviews (1-5 scale)
- Views count unique visitors to the marketplace listing
- Use for monitoring marketplace performance
