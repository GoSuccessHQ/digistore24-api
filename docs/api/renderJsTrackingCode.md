# renderJsTrackingCode

Render JavaScript tracking code for a product.

## Endpoint

```
POST /json/renderJsTrackingCode
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `product_id` | int | Yes | Product ID |
| `purchase_id` | string | No | Purchase ID for conversion tracking |
| `amount` | float | No | Transaction amount |
| `currency` | string | No | Currency code |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'product_id' => 123,
        'tracking_code' => '<script>
            // Google Analytics tracking
            gtag("event", "purchase", {
                transaction_id: "ABCD1234",
                value: 99.00,
                currency: "EUR",
                items: [{
                    item_id: "123",
                    item_name: "Premium Course",
                    price: 99.00,
                    quantity: 1
                }]
            });
            
            // Facebook Pixel tracking
            fbq("track", "Purchase", {
                value: 99.00,
                currency: "EUR",
                content_ids: ["123"],
                content_type: "product"
            });
        </script>'
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

// Get tracking code for product
$response = $api->tracking->renderJsTrackingCode(
    productId: 123
);

echo "Tracking Code:\n";
echo $response->trackingCode;

// Get tracking code with purchase details
$response = $api->tracking->renderJsTrackingCode(
    productId: 123,
    purchaseId: 'ABCD1234',
    amount: 99.00,
    currency: 'EUR'
);

// Output tracking code to page
echo $response->trackingCode;

// Example: Embed in thank-you page
$trackingCode = $response->trackingCode;
echo <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>Thank You</title>
</head>
<body>
    <h1>Thank you for your purchase!</h1>
    {$trackingCode}
</body>
</html>
HTML;
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid product ID or amount |
| 404 | Product not found | Specified product does not exist |
| 403 | Access denied | No permission to access this product |

## Notes

- Includes Google Analytics and Facebook Pixel tracking
- Automatically includes configured tracking pixels
- Use on thank-you/confirmation pages
- Purchase ID enables conversion tracking
- Amount and currency optional for page views
- Code includes all active tracking integrations
