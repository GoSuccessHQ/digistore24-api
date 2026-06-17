# listOrderforms

List all order forms.

## Endpoint

```
POST /json/listOrderforms
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `product_id` | int | No | Filter by product ID |
| `is_active` | bool | No | Filter by active status |
| `design` | string | No | Filter by design template |
| `language` | string | No | Filter by language |
| `limit` | int | No | Results per page (default: 100, max: 500) |
| `offset` | int | No | Pagination offset |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'orderforms' => [
            [
                'orderform_id' => 456,
                'product_id' => 123,
                'name' => 'Premium Order Form',
                'url' => 'https://www.digistore24.com/orderform/456',
                'design' => 'modern',
                'language' => 'en',
                'is_active' => true,
                'views' => 1250,
                'conversions' => 37,
                'conversion_rate' => 2.96,
                'created_at' => '2025-01-15T10:30:00Z'
            ],
            [
                'orderform_id' => 457,
                'product_id' => 124,
                'name' => 'Basic Order Form',
                'url' => 'https://www.digistore24.com/orderform/457',
                'design' => 'default',
                'language' => 'de',
                'is_active' => true,
                'views' => 850,
                'conversions' => 28,
                'conversion_rate' => 3.29,
                'created_at' => '2025-02-10T15:20:00Z'
            ]
            // ... more order forms
        ],
        'total' => 45,
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

// List all order forms
$response = $api->orderForms->listOrderforms(
    limit: 50
);

echo "Total: {$response->total} order forms\n\n";
foreach ($response->orderforms as $orderform) {
    echo "ID: {$orderform->orderformId}\n";
    echo "Name: {$orderform->name}\n";
    echo "URL: {$orderform->url}\n";
    echo "Design: {$orderform->design}\n";
    echo "Views: {$orderform->views}, Conversions: {$orderform->conversions}\n";
    echo "Conversion Rate: {$orderform->conversionRate}%\n\n";
}

// Filter by product
$response = $api->orderForms->listOrderforms(
    productId: 123
);

// Filter active order forms only
$response = $api->orderForms->listOrderforms(
    isActive: true
);

// Filter by design template
$response = $api->orderForms->listOrderforms(
    design: 'modern'
);

// Filter by language
$response = $api->orderForms->listOrderforms(
    language: 'en'
);

// Pagination
$response = $api->orderForms->listOrderforms(
    limit: 20,
    offset: 0
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid filter values or pagination parameters |

## Notes

- Results ordered by creation date (newest first)
- Includes performance statistics for each order form
- Max 500 results per request
- Use pagination for large result sets
- Conversion rate calculated as (conversions / views) * 100
- Filter combinations supported
