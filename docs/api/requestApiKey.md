# requestApiKey

Request a new API key for your Digistore24 account.

## Endpoint

```
POST /json/requestApiKey
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `email` | string | Yes | Your Digistore24 account email |
| `password` | string | Yes | Your Digistore24 account password |
| `description` | string | No | Description for this API key (e.g., "Production Server") |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'api_key' | 'YOUR-NEW-API-KEY',
        'created_at' => '2025-10-15 14:30:00',
        'description' => 'Production Server',
        'permissions' => ['read', 'write'],
        'rate_limit' => 1000
    ]
]
```

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

// Initialize API client with existing key (or use HTTP client directly)
$config = new Configuration('TEMP-API-KEY');
$api = new Digistore24($config);

// Request new API key
$response = $api->apiKeys->requestApiKey(
    email: 'your-email@example.com',
    password: 'your-password',
    description: 'Production Server'
);

echo "New API Key: {$response->apiKey}\n";
echo "Store this securely - it cannot be retrieved later!\n";
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 401 | Invalid credentials | Email/password combination is incorrect |
| 403 | Account not verified | Email address not verified |
| 429 | Too many requests | Rate limit exceeded |

## Notes

- **IMPORTANT**: Store the returned API key securely immediately
- API keys cannot be retrieved after creation
- Each account can have multiple API keys
- Use descriptions to identify different keys
- Keys have read/write permissions by default
- Revoke unused keys for security
