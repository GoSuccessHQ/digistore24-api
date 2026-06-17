# getOrderform

Get order form details.

## Endpoint

```
POST /json/getOrderform
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `orderform_id` | int | Yes | Order form ID |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'orderform_id' => 456,
        'product_id' => 123,
        'name' => 'Premium Order Form',
        'url' => 'https://www.digistore24.com/orderform/456',
        'design' => 'modern',
        'language' => 'en',
        'payment_methods' => ['paypal', 'credit_card', 'sepa'],
        'show_quantity_selector' => true,
        'show_coupon_field' => true,
        'redirect_url' => 'https://example.com/thank-you',
        'custom_fields' => [
            [
                'label' => 'Company',
                'type' => 'text',
                'required' => false
            ]
        ],
        'tracking_code' => 'ga_12345',
        'is_active' => true,
        'views' => 1250,
        'conversions' => 37,
        'conversion_rate' => 2.96,
        'created_at' => '2025-01-15T10:30:00Z',
        'updated_at' => '2025-03-20T14:45:00Z'
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

// Get order form details
$response = $api->orderForms->getOrderform(
    orderformId: 456
);

echo "Name: {$response->name}\n";
echo "URL: {$response->url}\n";
echo "Design: {$response->design}\n";
echo "Language: {$response->language}\n";
echo "Views: {$response->views}\n";
echo "Conversions: {$response->conversions}\n";
echo "Conversion Rate: {$response->conversionRate}%\n";

// Check if order form is active
if ($response->isActive) {
    echo "Order form is active\n";
    echo "Payment methods: " . implode(', ', $response->paymentMethods) . "\n";
}

// Display custom fields
if (!empty($response->customFields)) {
    echo "Custom fields:\n";
    foreach ($response->customFields as $field) {
        echo "  - {$field['label']} ({$field['type']})";
        echo $field['required'] ? " - Required\n" : "\n";
    }
}
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid order form ID |
| 404 | Order form not found | Specified order form does not exist |
| 403 | Access denied | No permission to access this order form |

## Notes

- Includes performance statistics (views, conversions, conversion rate)
- Conversion rate = (conversions / views) * 100
- Statistics updated in real-time
- Use for monitoring order form performance
- Returns complete configuration including custom fields
