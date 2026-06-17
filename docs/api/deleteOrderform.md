# deleteOrderform

Delete an order form.

## Endpoint

```
POST /json/deleteOrderform
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `orderform_id` | int | Yes | Order form ID to delete |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'orderform_id' => 456,
        'deleted' => true,
        'deleted_at' => '2025-03-20T17:45:00Z'
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

// Delete order form
$response = $api->orderForms->deleteOrderform(
    orderformId: 456
);

if ($response->deleted) {
    echo "Order form {$response->orderformId} deleted successfully\n";
    echo "Deleted at: {$response->deletedAt}\n";
}

// Example: Delete order form after checking it exists
try {
    // First verify it exists
    $orderform = $api->orderForms->getOrderform(orderformId: 456);
    
    // Then delete it
    $response = $api->orderForms->deleteOrderform(
        orderformId: 456
    );
    
    echo "Order form '{$orderform->name}' has been deleted\n";
} catch (\Exception $e) {
    echo "Error: {$e->getMessage()}\n";
}
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid order form ID |
| 404 | Order form not found | Specified order form does not exist |
| 403 | Access denied | No permission to delete this order form |
| 409 | Order form in use | Cannot delete order form with active purchases |

## Notes

- Deletion is permanent and cannot be undone
- Order forms with active purchases cannot be deleted
- Deactivate order form first if you want to keep it for reference
- Statistics history will be lost
- Consider exporting statistics before deletion
- URL will no longer be accessible after deletion
