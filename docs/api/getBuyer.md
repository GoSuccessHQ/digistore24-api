# getBuyer

Get detailed information about a buyer.

## Endpoint

```
GET /getBuyer
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `buyer_id` | string | Yes | Buyer ID or email address |

## Response Fields

| Field | Type | Description |
|-------|------|-------------|
| `buyer` | object | Buyer data object |

### Buyer Object

| Field | Type | Description |
|-------|------|-------------|
| `id` | string | Buyer ID |
| `address_id` | string | Address ID |
| `email` | string | Email address |
| `salutation` | string | Salutation code (M, F, or empty) |
| `salutation_msg` | string | Salutation message |
| `title` | string | Academic or professional title |
| `first_name` | string | First name |
| `last_name` | string | Last name |
| `company` | string | Company name |
| `street` | string | Full street address |
| `street_name` | string | Street name (without number) |
| `street_number` | string | Street number |
| `street2` | string | Additional address line |
| `zipcode` | string | ZIP/Postal code |
| `city` | string | City name |
| `state` | string | State/Province |
| `country` | string | Country code (ISO 3166-1 alpha-2) |
| `phone_no` | string | Phone number |
| `buyer_type` | string | Buyer type: "business", "consumer", "common", "vendor" |
| `created_at` | string | Creation timestamp (YYYY-MM-DD HH:MM:SS) |

## Response Structure (PHP)

```php
GetBuyerResponse {
  +buyer: BuyerData {
    +id: ?int
    +addressId: ?int
    +email: string
    +salutation: ?Salutation
    +salutationMsg: ?string
    +title: ?string
    +firstName: ?string
    +lastName: ?string
    +company: ?string
    +street: ?string
    +streetName: ?string
    +streetNumber: ?string
    +street2: ?string
    +zipcode: ?string
    +city: ?string
    +state: ?string
    +country: ?string
    +phoneNo: ?string
    +buyerType: ?BuyerType
    +createdAt: ?DateTimeImmutable
  }
}
```

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Buyer\GetBuyerRequest;

$config = new Configuration('YOUR-API-KEY');
$api = new Digistore24($config);

// Get buyer by ID
$request = new GetBuyerRequest(buyerId: '18141656');
$response = $api->buyers->get($request);

// Access buyer data
$buyer = $response->buyer;
echo "Buyer: {$buyer->firstName} {$buyer->lastName}\n";
echo "Email: {$buyer->email}\n";
echo "Company: {$buyer->company}\n";
echo "Type: {$buyer->buyerType?->value}\n";
echo "Created: {$buyer->createdAt?->format('Y-m-d H:i:s')}\n";

// Get buyer by email
$request = new GetBuyerRequest(buyerId: 'paul@gosuccess.io');
$response = $api->buyers->get($request);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 401 | Unauthorized | Invalid or missing API key |
| 403 | Forbidden | Insufficient access rights |
| 404 | Not found | Buyer with specified ID does not exist |

## Notes

- Accepts buyer ID or email address as `buyer_id` parameter
- Returns comprehensive buyer and address information
- Country codes follow ISO 3166-1 alpha-2 standard
- Buyer type indicates whether buyer is business or consumer
- Created timestamp is in the format YYYY-MM-DD HH:MM:SS
