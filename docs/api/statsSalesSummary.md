# statsSalesSummary

Get sales summary statistics.

## Endpoint

```
POST /json/statsSalesSummary
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `product_id` | int | No | Filter by product ID |
| `period` | string | No | Period (today, yesterday, this_week, this_month, this_year, all_time) |
| `start_date` | string | No | Start date (Y-m-d, overrides period) |
| `end_date` | string | No | End date (Y-m-d, overrides period) |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'period' => 'this_month',
        'start_date' => '2025-03-01',
        'end_date' => '2025-03-31',
        'sales_count' => 345,
        'revenue' => 38675.00,
        'currency' => 'EUR',
        'average_order_value' => 112.10,
        'refunds_count' => 15,
        'refunds_amount' => 450.00,
        'refund_rate' => 4.35,
        'net_revenue' => 38225.00,
        'by_product' => [
            [
                'product_id' => 123,
                'product_name' => 'Premium Course',
                'sales_count' => 187,
                'revenue' => 18513.00
            ],
            [
                'product_id' => 124,
                'product_name' => 'Basic Course',
                'sales_count' => 158,
                'revenue' => 20162.00
            ]
        ],
        'by_country' => [
            [
                'country_code' => 'DE',
                'country_name' => 'Germany',
                'sales_count' => 145,
                'revenue' => 16245.00
            ],
            [
                'country_code' => 'US',
                'country_name' => 'United States',
                'sales_count' => 87,
                'revenue' => 9745.00
            ]
            // ... more countries
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

// Get current month summary
$response = $api->statistics->statsSalesSummary(
    period: 'this_month'
);

echo "Sales Summary for {$response->period}\n";
echo "Period: {$response->startDate} to {$response->endDate}\n\n";
echo "Sales Count: {$response->salesCount}\n";
echo "Revenue: {$response->currency} {$response->revenue}\n";
echo "Average Order Value: {$response->currency} {$response->averageOrderValue}\n";
echo "Refunds: {$response->refundsCount} ({$response->currency} {$response->refundsAmount})\n";
echo "Refund Rate: {$response->refundRate}%\n";
echo "Net Revenue: {$response->currency} {$response->netRevenue}\n\n";

// Display breakdown by product
if (!empty($response->byProduct)) {
    echo "By Product:\n";
    foreach ($response->byProduct as $product) {
        echo "  {$product->productName}: {$product->salesCount} sales, ";
        echo "{$response->currency} {$product->revenue}\n";
    }
}

// Get today's summary
$response = $api->statistics->statsSalesSummary(
    period: 'today'
);

// Get this year's summary
$response = $api->statistics->statsSalesSummary(
    period: 'this_year'
);

// Get all-time summary
$response = $api->statistics->statsSalesSummary(
    period: 'all_time'
);

// Custom date range
$response = $api->statistics->statsSalesSummary(
    startDate: '2025-01-01',
    endDate: '2025-12-31'
);

// Filter by product
$response = $api->statistics->statsSalesSummary(
    productId: 123,
    period: 'this_month'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid period or date format |
| 404 | Product not found | Specified product does not exist |

## Notes

- Available periods: `today`, `yesterday`, `this_week`, `this_month`, `this_year`, `all_time`
- Custom date range overrides period parameter
- Includes breakdown by product and country
- Net revenue = revenue - refunds_amount
- Use for dashboard and reporting
- Data updated hourly
