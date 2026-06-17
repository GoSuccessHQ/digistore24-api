# statsSales

Get sales statistics.

## Endpoint

```
POST /json/statsSales
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `product_id` | int | No | Filter by product ID |
| `start_date` | string | Yes | Start date (Y-m-d) |
| `end_date` | string | Yes | End date (Y-m-d) |
| `group_by` | string | No | Group by (day, week, month, product, country) |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'start_date' => '2025-03-01',
        'end_date' => '2025-03-31',
        'group_by' => 'day',
        'sales' => [
            [
                'period' => '2025-03-01',
                'sales_count' => 12,
                'revenue' => 1245.00,
                'average_order_value' => 103.75,
                'refunds_count' => 0,
                'refunds_amount' => 0.00
            ],
            [
                'period' => '2025-03-02',
                'sales_count' => 10,
                'revenue' => 985.50,
                'average_order_value' => 98.55,
                'refunds_count' => 1,
                'refunds_amount' => 49.00
            ]
            // ... more periods
        ],
        'total_sales' => 345,
        'total_revenue' => 38675.00,
        'average_order_value' => 112.10,
        'total_refunds' => 15,
        'total_refunds_amount' => 450.00,
        'refund_rate' => 4.35
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

// Get daily sales statistics
$response = $api->statistics->statsSales(
    startDate: '2025-03-01',
    endDate: '2025-03-31',
    groupBy: 'day'
);

echo "Period: {$response->startDate} to {$response->endDate}\n";
echo "Total Sales: {$response->totalSales}\n";
echo "Total Revenue: € {$response->totalRevenue}\n";
echo "Average Order Value: € {$response->averageOrderValue}\n";
echo "Refund Rate: {$response->refundRate}%\n\n";

// Display sales by day
foreach ($response->sales as $sale) {
    echo "{$sale->period}: {$sale->salesCount} sales, € {$sale->revenue}\n";
}

// Group by week
$response = $api->statistics->statsSales(
    startDate: '2025-01-01',
    endDate: '2025-12-31',
    groupBy: 'week'
);

// Group by month
$response = $api->statistics->statsSales(
    startDate: '2025-01-01',
    endDate: '2025-12-31',
    groupBy: 'month'
);

// Group by product
$response = $api->statistics->statsSales(
    startDate: '2025-03-01',
    endDate: '2025-03-31',
    groupBy: 'product'
);

// Group by country
$response = $api->statistics->statsSales(
    startDate: '2025-03-01',
    endDate: '2025-03-31',
    groupBy: 'country'
);

// Filter by product
$response = $api->statistics->statsSales(
    productId: 123,
    startDate: '2025-01-01',
    endDate: '2025-12-31'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid date format or range |
| 404 | Product not found | Specified product does not exist |

## Notes

- Maximum date range is 365 days
- Group by options: `day`, `week`, `month`, `product`, `country`
- Refund rate = (refunds_count / sales_count) * 100
- Use for sales analysis and reporting
- Data updated hourly
