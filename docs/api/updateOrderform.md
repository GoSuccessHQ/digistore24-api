# updateOrderform

Update an existing order form.

## Endpoint

```
POST /json/updateOrderform
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `orderform_id` | int | Yes | Order form ID |
| `name` | string | No | Order form name |
| `design` | string | No | Design template (default, modern, minimal) |
| `language` | string | No | Language code (de, en, fr, es, it) |
| `payment_methods` | array | No | Allowed payment methods |
| `show_quantity_selector` | bool | No | Allow quantity selection |
| `show_coupon_field` | bool | No | Show coupon input field |
| `redirect_url` | string | No | Redirect URL after purchase |
| `custom_fields` | array | No | Custom form fields |
| `tracking_code` | string | No | Custom tracking code |
| `is_active` | bool | No | Active status |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'orderform_id' => 456,
        'product_id' => 123,
        'name' => 'Updated Order Form',
        'url' => 'https://www.digistore24.com/orderform/456',
        'design' => 'minimal',
        'language' => 'de',
        'payment_methods' => ['paypal', 'sepa'],
        'show_quantity_selector' => false,
        'show_coupon_field' => true,
        'redirect_url' => 'https://example.com/new-thank-you',
        'custom_fields' => [
            [
                'label' => 'Telefonnummer',
                'type' => 'text',
                'required' => true
            ]
        ],
        'is_active' => true,
        'updated_at' => '2025-03-20T16:30:00Z'
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

// Update order form name
$response = $api->orderForms->updateOrderform(
    orderformId: 456,
    name: 'Updated Order Form'
);

echo "Order form updated successfully\n";
echo "Name: {$response->name}\n";

// Change design and language
$response = $api->orderForms->updateOrderform(
    orderformId: 456,
    design: 'minimal',
    language: 'de'
);

// Update payment methods
$response = $api->orderForms->updateOrderform(
    orderformId: 456,
    paymentMethods: ['paypal', 'sepa']
);

// Update redirect URL
$response = $api->orderForms->updateOrderform(
    orderformId: 456,
    redirectUrl: 'https://example.com/new-thank-you'
);

// Add custom fields
$response = $api->orderForms->updateOrderform(
    orderformId: 456,
    customFields: [
        [
            'label' => 'Telefonnummer',
            'type' => 'text',
            'required' => true
        ],
        [
            'label' => 'Firmenname',
            'type' => 'text',
            'required' => false
        ]
    ]
);

// Deactivate order form
$response = $api->orderForms->updateOrderform(
    orderformId: 456,
    isActive: false
);

// Update multiple settings
$response = $api->orderForms->updateOrderform(
    orderformId: 456,
    name: 'Complete Update',
    design: 'modern',
    language: 'en',
    showQuantitySelector: true,
    showCouponField: false,
    trackingCode: 'ga_updated'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid data provided |
| 404 | Order form not found | Specified order form does not exist |
| 403 | Access denied | No permission to update this order form |

## Notes

- Only provided parameters are updated
- Other settings remain unchanged
- Available designs: `default`, `modern`, `minimal`
- Available languages: `de`, `en`, `fr`, `es`, `it`
- Payment methods: `paypal`, `credit_card`, `sepa`, `sofort`, `giropay`
- Changes take effect immediately
- Active order forms can be updated without deactivation
