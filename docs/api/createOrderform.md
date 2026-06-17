# createOrderform

Create a new order form.

## Endpoint

```
POST /json/createOrderform
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `product_id` | int | Yes | Product ID |
| `name` | string | Yes | Order form name |
| `design` | string | No | Design template (default, modern, minimal) |
| `language` | string | No | Language code (de, en, fr, es, it) |
| `payment_methods` | array | No | Allowed payment methods |
| `show_quantity_selector` | bool | No | Allow quantity selection (default: false) |
| `show_coupon_field` | bool | No | Show coupon input field (default: true) |
| `redirect_url` | string | No | Redirect URL after purchase |
| `custom_fields` | array | No | Custom form fields |
| `tracking_code` | string | No | Custom tracking code |

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
        'is_active' => true,
        'created_at' => '2025-01-15T10:30:00Z'
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

// Create basic order form
$response = $api->orderForms->createOrderform(
    productId: 123,
    name: 'Standard Order Form'
);

echo "Order Form ID: {$response->orderformId}\n";
echo "URL: {$response->url}\n";

// Create advanced order form with custom settings
$response = $api->orderForms->createOrderform(
    productId: 123,
    name: 'Premium Order Form',
    design: 'modern',
    language: 'en',
    paymentMethods: ['paypal', 'credit_card', 'sepa'],
    showQuantitySelector: true,
    showCouponField: true,
    redirectUrl: 'https://example.com/thank-you',
    customFields: [
        [
            'label' => 'Company',
            'type' => 'text',
            'required' => false
        ],
        [
            'label' => 'VAT ID',
            'type' => 'text',
            'required' => false
        ]
    ],
    trackingCode: 'ga_12345'
);

// Create order form with specific payment methods
$response = $api->orderForms->createOrderform(
    productId: 123,
    name: 'PayPal Only Form',
    paymentMethods: ['paypal']
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Missing required fields or invalid data |
| 404 | Product not found | Specified product does not exist |
| 403 | Access denied | No permission to create order forms |

## Notes

- Available designs: `default`, `modern`, `minimal`
- Available languages: `de`, `en`, `fr`, `es`, `it`
- Payment methods: `paypal`, `credit_card`, `sepa`, `sofort`, `giropay`
- Custom fields support: `text`, `textarea`, `checkbox`, `select`
- Order form URL is automatically generated
- Use for customized checkout experiences
- Can be embedded via iframe or direct link
