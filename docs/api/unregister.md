# unregister

Revoke an API key and remove API access.

## Endpoint

```
POST /json/unregister
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `api_key` | string | Yes | The API key to revoke |
| `confirm` | bool | Yes | Confirmation flag (must be true) |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'api_key_id' => 'KEY123',
        'revoked_at' => '2025-10-15 14:30:00',
        'message' => 'API key has been revoked successfully'
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

// Revoke API key
$response = $api->apiKeys->unregister(
    apiKey: 'KEY-TO-REVOKE',
    confirm: true
);

echo "API key revoked at: {$response->revokedAt}\n";
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Missing confirmation | confirm parameter not set to true |
| 404 | API key not found | Key does not exist or already revoked |
| 403 | Cannot revoke active key | Cannot revoke the key being used for the request |

## Notes

- **WARNING**: This action is permanent and cannot be undone
- Revoked keys cannot be reactivated
- Cannot revoke the key you're currently using
- All applications using this key will lose access immediately
- Consider using API key management UI for safer revocation
- Confirmation parameter is required to prevent accidental revocation
