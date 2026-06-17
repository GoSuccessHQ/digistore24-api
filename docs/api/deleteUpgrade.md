# deleteUpgrade

Delete an upgrade.

## Endpoint

```
POST /json/deleteUpgrade
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `upgrade_id` | int | Yes | Upgrade ID to delete |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'upgrade_id' => 789,
        'deleted' => true,
        'deleted_at' => '2025-03-21T01:00:00Z'
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

// Delete upgrade
$response = $api->upgrades->deleteUpgrade(
    upgradeId: 789
);

if ($response->deleted) {
    echo "Upgrade {$response->upgradeId} deleted successfully\n";
    echo "Deleted at: {$response->deletedAt}\n";
}

// Example: Delete after confirmation
try {
    // Get upgrade details first
    $upgrade = $api->upgrades->getUpgrade(upgradeId: 789);
    
    echo "About to delete: {$upgrade->name}\n";
    echo "Path: {$upgrade->fromProductName} → {$upgrade->toProductName}\n";
    echo "Conversions: {$upgrade->conversionsCount}\n";
    
    // Proceed with deletion
    $response = $api->upgrades->deleteUpgrade(
        upgradeId: 789
    );
    
    echo "Upgrade deleted successfully\n";
} catch (\Exception $e) {
    echo "Error: {$e->getMessage()}\n";
}
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid upgrade ID |
| 404 | Upgrade not found | Specified upgrade does not exist |
| 403 | Access denied | No permission to delete this upgrade |

## Notes

- Deletion is permanent and cannot be undone
- Does not affect completed upgrades/purchases
- Statistics history will be lost
- Consider deactivating instead of deleting for historical data
- Export statistics before deletion if needed
