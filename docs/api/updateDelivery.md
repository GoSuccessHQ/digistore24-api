# updateDelivery

Update delivery information.

## Endpoint

```
POST /json/updateDelivery
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `delivery_id` | int | Yes | Delivery ID |
| `tracking_number` | string | No | Tracking number |
| `carrier` | string | No | Carrier name (DHL, UPS, FedEx, etc.) |
| `status` | string | No | Delivery status |
| `shipped_at` | string | No | Shipping date/time (Y-m-d H:i:s) |
| `delivered_at` | string | No | Delivery date/time (Y-m-d H:i:s) |
| `notes` | string | No | Delivery notes |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'delivery_id' => 123,
        'tracking_number' => 'TRACK123456',
        'carrier' => 'DHL',
        'status' => 'shipped',
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

// Update tracking information
$response = $api->deliveries->updateDelivery(
    deliveryId: 123,
    trackingNumber: 'TRACK123456',
    carrier: 'DHL',
    status: 'shipped',
    shippedAt: '2025-10-15 10:00:00'
);

// Mark as delivered
$response = $api->deliveries->updateDelivery(
    deliveryId: 123,
    status: 'delivered',
    deliveredAt: '2025-10-17 14:30:00'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 404 | Delivery not found | Delivery ID does not exist |
| 400 | Invalid parameters | Invalid status or date format |
| 403 | Access denied | Not authorized to update this delivery |

## Notes

- Only provided fields will be updated
- Status values: pending, shipped, in_transit, delivered, failed, returned
- Setting shipped_at automatically updates status to 'shipped'
- Customers receive notification on status changes
- Use for fulfillment workflow integration
