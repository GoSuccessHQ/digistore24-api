# updateBuyer

Update buyer information.

## Endpoint

```
POST /json/updateBuyer
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `email` | string | Yes* | Buyer's email address |
| `buyer_id` | int | Yes* | Buyer's ID |
| `first_name` | string | No | First name |
| `last_name` | string | No | Last name |
| `company` | string | No | Company name |
| `street` | string | No | Street address |
| `zipcode` | string | No | Postal code |
| `city` | string | No | City |
| `state` | string | No | State/Province |
| `country` | string | No | Country code (ISO 3166-1 alpha-2) |
| `phone` | string | No | Phone number |
| `language` | string | No | Language code (de, en, es, etc.) |

*One of `email` or `buyer_id` is required to identify the buyer.

## Response

```php
[
    'result' => 'success',
    'data' => [
        'buyer_id' => 12345,
        'email' => 'buyer@example.com',
        'first_name' => 'John',
        'last_name' => 'Doe',
        'company' => 'Updated Corp',
        'updated_at' => '2025-10-15 14:30:00'
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

// Update buyer by email
$response = $api->buyers->updateBuyer(
    email: 'buyer@example.com',
    firstName: 'John',
    lastName: 'Smith',
    company: 'New Company GmbH',
    phone: '+49 30 12345678'
);

if ($response->result === 'success') {
    echo "Buyer updated: {$response->buyerId}";
}

// Update buyer by ID
$response = $api->buyers->updateBuyer(
    buyerId: 12345,
    street: '456 New Street',
    city: 'Munich',
    zipcode: '80331'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Missing required parameters or invalid format |
| 404 | Buyer not found | Buyer does not exist |
| 403 | Access denied | Not authorized to update buyer data |
| 422 | Validation error | Invalid country code or other validation error |

## Notes

- Only provided fields will be updated
- Email address cannot be changed through this endpoint
- Country codes must be valid ISO 3166-1 alpha-2 codes
- Changes are applied immediately
