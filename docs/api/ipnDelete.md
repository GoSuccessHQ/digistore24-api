# ipnDelete

Delete configured IPN (Instant Payment Notification) webhook.

## Endpoint

```
DELETE /ipnDelete
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `domain_id` | string | Yes | Domain ID of the IPN connection to delete |

## Response

```php
[
    'result' => 'success',
    'message' => 'IPN deleted successfully'
]
```

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$api = new Digistore24($config);

// Delete IPN by domain ID
$response = $api->ipn->delete('my-platform');

echo $response->message; // "IPN deleted successfully"
```

## Complete Example with Error Handling

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Exception\NotFoundException;

$config = new Configuration('YOUR-API-KEY');
$api = new Digistore24($config);

try {
    $domainId = 'my-platform';

    // Delete the IPN
    $response = $api->ipn->delete($domainId);

    echo "✓ IPN with domain_id '{$domainId}' deleted successfully\n";

} catch (NotFoundException $e) {
    echo "✗ IPN not found: {$e->getMessage()}\n";
} catch (\Exception $e) {
    echo "✗ Error: {$e->getMessage()}\n";
}
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 404 | IPN not found | No IPN configured with specified domain_id |
| 401 | Unauthorized | Invalid API key |
| 400 | Missing domain_id | Required parameter not provided |

## Notes

- Requires the `domain_id` parameter that was set during IPN setup
- Deletion is permanent and cannot be undone
- All webhook notifications for this IPN will stop immediately
- Use `ipnInfo` endpoint first to verify the domain_id
- After deletion, you can setup a new IPN with the same domain_id
