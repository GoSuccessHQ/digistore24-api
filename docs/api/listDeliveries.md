# listDeliveries

List all deliveries with optional filters.

## Endpoint

```
POST /json/listDeliveries
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `purchase_id` | string | No | Filter by purchase ID |
| `status` | string | No | Filter by status (pending, shipped, delivered, etc.) |
| `start_date` | string | No | Filter deliveries from date (Y-m-d) |
| `end_date` | string | No | Filter deliveries to date (Y-m-d) |
| `limit` | int | No | Number of results (default: 100, max: 1000) |
| `offset` | int | No | Offset for pagination |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'deliveries' => [
            [
                'delivery_id' => 123,
                'purchase_id' => 'ABC123',
                'tracking_number' => 'TRACK123',
                'carrier' => 'DHL',
                'status' => 'delivered',
                'shipped_at' => '2025-10-10 10:00:00',
                'delivered_at' => '2025-10-12 14:30:00'
            ],
            // ... more deliveries
        ],
        'total' => 250,
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

// List all deliveries
$response = $api->deliveries->listDeliveries(
    limit: 50
);

foreach ($response->deliveries as $delivery) {
    echo "Delivery {$delivery->deliveryId}: {$delivery->status}\n";
}

// Filter by status
$response = $api->deliveries->listDeliveries(
    status: 'shipped',
    limit: 100
);

// Get deliveries for specific purchase
$response = $api->deliveries->listDeliveries(
    purchaseId: 'ABC123'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid status or date format |

## Notes

- Results ordered by creation date (newest first)
- Use pagination for large result sets
- Status values: pending, shipped, in_transit, delivered, failed, returned
- Maximum 1000 results per request
