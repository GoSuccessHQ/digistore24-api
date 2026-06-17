# listShippingCostPolicies

List all shipping cost policies.

## Endpoint

```
POST /json/listShippingCostPolicies
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `product_id` | int | No | Filter by product ID |
| `country_code` | string | No | Filter by country code |
| `is_active` | bool | No | Filter by active status |
| `limit` | int | No | Results per page (default: 100, max: 500) |
| `offset` | int | No | Pagination offset |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'policies' => [
            [
                'policy_id' => 789,
                'name' => 'Germany Standard',
                'product_id' => 123,
                'product_name' => 'Physical Product',
                'country_code' => 'DE',
                'country_name' => 'Germany',
                'cost' => 5.99,
                'currency' => 'EUR',
                'free_shipping_threshold' => 50.00,
                'is_active' => true,
                'orders_count' => 245
            ],
            [
                'policy_id' => 790,
                'name' => 'US Standard',
                'product_id' => 123,
                'product_name' => 'Physical Product',
                'country_code' => 'US',
                'country_name' => 'United States',
                'cost' => 12.99,
                'currency' => 'USD',
                'free_shipping_threshold' => 100.00,
                'is_active' => true,
                'orders_count' => 187
            ]
            // ... more policies
        ],
        'total' => 35,
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

// List all shipping policies
$response = $api->shipping->listShippingCostPolicies(
    limit: 50
);

echo "Total policies: {$response->total}\n\n";
foreach ($response->policies as $policy) {
    echo "ID: {$policy->policyId}\n";
    echo "Name: {$policy->name}\n";
    echo "Country: {$policy->countryName}\n";
    echo "Cost: {$policy->currency} {$policy->cost}\n";
    echo "Orders: {$policy->ordersCount}\n\n";
}

// Filter by product
$response = $api->shipping->listShippingCostPolicies(
    productId: 123
);

// Filter by country
$response = $api->shipping->listShippingCostPolicies(
    countryCode: 'DE'
);

// Filter active policies only
$response = $api->shipping->listShippingCostPolicies(
    isActive: true
);

// Combined filters
$response = $api->shipping->listShippingCostPolicies(
    productId: 123,
    countryCode: 'US',
    isActive: true
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid filter values or pagination parameters |

## Notes

- Results ordered by creation date (newest first)
- Includes usage statistics (orders count)
- Max 500 results per request
- Use pagination for large result sets
- Filter combinations supported
