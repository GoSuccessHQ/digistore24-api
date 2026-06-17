# getOrderformMetas

Get order form meta information.

## Endpoint

```
POST /json/getOrderformMetas
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
        'meta_title' => 'Buy Premium Product Now',
        'meta_description' => 'Get instant access to our premium product with secure checkout.',
        'meta_keywords' => 'premium, product, buy, checkout',
        'og_title' => 'Premium Product - Special Offer',
        'og_description' => 'Limited time offer on our premium product.',
        'og_image' => 'https://example.com/images/product.jpg',
        'og_type' => 'product',
        'twitter_card' => 'summary_large_image',
        'twitter_title' => 'Premium Product',
        'twitter_description' => 'Get instant access now',
        'twitter_image' => 'https://example.com/images/product-twitter.jpg',
        'favicon' => 'https://example.com/favicon.ico',
        'custom_css' => '.checkout-button { background: #ff6600; }',
        'custom_js' => 'console.log("Order form loaded");',
        'tracking_pixels' => [
            [
                'provider' => 'facebook',
                'pixel_id' => 'FB123456789'
            ],
            [
                'provider' => 'google',
                'conversion_id' => 'AW-987654321'
            ]
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

// Get order form meta information
$response = $api->orderForms->getOrderformMetas(
    orderformId: 456
);

// Display SEO meta tags
echo "Meta Title: {$response->metaTitle}\n";
echo "Meta Description: {$response->metaDescription}\n";
echo "Meta Keywords: {$response->metaKeywords}\n";

// Display Open Graph (Facebook) meta tags
echo "\nOpen Graph:\n";
echo "Title: {$response->ogTitle}\n";
echo "Description: {$response->ogDescription}\n";
echo "Image: {$response->ogImage}\n";
echo "Type: {$response->ogType}\n";

// Display Twitter Card meta tags
echo "\nTwitter Card:\n";
echo "Card Type: {$response->twitterCard}\n";
echo "Title: {$response->twitterTitle}\n";
echo "Description: {$response->twitterDescription}\n";
echo "Image: {$response->twitterImage}\n";

// Display tracking pixels
if (!empty($response->trackingPixels)) {
    echo "\nTracking Pixels:\n";
    foreach ($response->trackingPixels as $pixel) {
        echo "  - {$pixel['provider']}: {$pixel['pixel_id'] ?? $pixel['conversion_id']}\n";
    }
}

// Check custom styling
if (!empty($response->customCss)) {
    echo "\nCustom CSS is configured\n";
}
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid order form ID |
| 404 | Order form not found | Specified order form does not exist |
| 403 | Access denied | No permission to access this order form |

## Notes

- Meta tags optimize SEO and social media sharing
- Open Graph tags control Facebook/LinkedIn previews
- Twitter Card tags control Twitter previews
- Tracking pixels: Facebook Pixel, Google Ads, LinkedIn Insight
- Custom CSS/JS allows advanced customization
- Use for order form branding and tracking setup
