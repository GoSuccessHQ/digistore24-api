# statsAffiliateToplist

Get affiliate performance statistics and top performers.

## Endpoint

```
POST /json/statsAffiliateToplist
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `product_id` | int | No | Filter by product ID (empty = all products) |
| `start_date` | string | No | Start date (Y-m-d) |
| `end_date` | string | No | End date (Y-m-d) |
| `limit` | int | No | Number of results (default: 50, max: 500) |
| `order_by` | string | No | Sort by: 'sales', 'revenue', 'commissions' (default: 'revenue') |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'affiliates' => [
            [
                'affiliate_id' => 789,
                'affiliate_code' => 'AFFILIATE123',
                'name' => 'John Doe',
                'email' => 'affiliate@example.com',
                'total_sales' => 150,
                'total_revenue' => 15000.00,
                'total_commissions' => 7500.00,
                'conversion_rate' => 3.5
            ],
            // ... more affiliates
        ],
        'total_affiliates' => 250,
        'period' => [
            'start' => '2025-01-01',
            'end' => '2025-10-15'
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

// Get top 10 affiliates by revenue
$response = $api->statistics->statsAffiliateToplist(
    limit: 10,
    orderBy: 'revenue'
);

foreach ($response->affiliates as $affiliate) {
    echo "{$affiliate->name}: € {$affiliate->totalRevenue}\n";
    echo "  Sales: {$affiliate->totalSales}\n";
    echo "  Commissions: € {$affiliate->totalCommissions}\n";
}

// Get top performers for specific product
$response = $api->statistics->statsAffiliateToplist(
    productId: 12345,
    startDate: '2025-01-01',
    endDate: '2025-12-31',
    limit: 20
);

// Get top sellers by number of sales
$response = $api->statistics->statsAffiliateToplist(
    orderBy: 'sales',
    limit: 50
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid date format or limit |
| 404 | Product not found | Specified product does not exist |

## Notes

- Default period is last 30 days if dates not specified
- Conversion rate is percentage of visitors who purchased
- Results are ordered by specified metric (revenue default)
- Use for affiliate leaderboards and performance analysis
- Maximum 500 results per request
