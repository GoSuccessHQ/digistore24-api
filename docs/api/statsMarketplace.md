# statsMarketplace

Get marketplace statistics.

## Endpoint

```
POST /json/statsMarketplace
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `entry_id` | int | No | Specific entry ID (empty = all entries) |
| `start_date` | string | No | Start date (Y-m-d) |
| `end_date` | string | No | End date (Y-m-d) |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'total_views' => 15000,
        'total_sales' => 450,
        'total_revenue' => 44925.00,
        'conversion_rate' => 3.0,
        'average_rating' => 4.3,
        'total_reviews' => 120,
        'by_category' => [
            'Software' => [
                'views' => 8000,
                'sales' => 250,
                'revenue' => 24975.00
            ],
            // ... more categories
        ],
        'top_products' => [
            [
                'entry_id' => 123,
                'title' => 'Top Product',
                'sales' => 150,
                'revenue' => 14985.00
            ],
            // ... more products
        ]
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

// Get overall marketplace statistics
$response = $api->marketplace->statsMarketplace();

echo "Total Views: {$response->totalViews}\n";
echo "Total Sales: {$response->totalSales}\n";
echo "Revenue: € {$response->totalRevenue}\n";
echo "Conversion Rate: {$response->conversionRate}%\n";

// Get statistics for specific entry
$response = $api->marketplace->statsMarketplace(
    entryId: 123,
    startDate: '2025-01-01',
    endDate: '2025-12-31'
);

// Get statistics for date range
$response = $api->marketplace->statsMarketplace(
    startDate: '2025-10-01',
    endDate: '2025-10-31'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid date format |
| 404 | Entry not found | Specified entry does not exist |

## Notes

- Default period is last 30 days if dates not specified
- Conversion rate = (sales / views) * 100
- Statistics updated hourly
- Use for marketplace performance analysis
- Top products limited to top 10
