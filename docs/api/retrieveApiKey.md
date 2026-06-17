# retrieveApiKey

Retrieve information about an existing API key (not the key itself).

## Endpoint

```
POST /json/retrieveApiKey
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `api_key_id` | string | Yes | The API key ID (not the key itself) |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'api_key_id' => 'KEY123',
        'description' => 'Production Server',
        'created_at' => '2025-01-15 10:30:00',
        'last_used_at' => '2025-10-15 14:25:00',
        'is_active' => true,
        'permissions' => ['read', 'write'],
        'rate_limit' => 1000,
        'requests_today' => 450
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

// Get API key information
$response = $api->apiKeys->retrieveApiKey(
    apiKeyId: 'KEY123'
);

echo "Description: {$response->description}\n";
echo "Created: {$response->createdAt}\n";
echo "Last used: {$response->lastUsedAt}\n";
echo "Requests today: {$response->requestsToday}/{$response->rateLimit}\n";
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 404 | API key not found | Key ID does not exist |
| 403 | Access denied | Not authorized to access this key |

## Notes

- This endpoint returns key **information**, not the key itself
- API keys cannot be retrieved once created
- Use this to monitor key usage and status
- Check `requests_today` to monitor rate limit usage
- Inactive keys return is_active=false
