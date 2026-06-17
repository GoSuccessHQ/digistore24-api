# deleteVoucher

Delete a voucher permanently.

## Endpoint

```
POST /json/deleteVoucher
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `voucher_id` | int | Yes* | Voucher ID |
| `code` | string | Yes* | Voucher code |

*One of `voucher_id` or `code` is required.

## Response

```php
[
    'result' => 'success',
    'data' => [
        'voucher_id' => 789,
        'code' => 'SUMMER2025',
        'deleted_at' => '2025-10-15 14:30:00'
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

// Delete voucher by ID
$response = $api->vouchers->deleteVoucher(
    voucherId: 789
);

if ($response->result === 'success') {
    echo "Voucher {$response->code} deleted";
}

// Delete voucher by code
$response = $api->vouchers->deleteVoucher(
    code: 'EXPIRED2024'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Missing parameter | Neither voucher_id nor code provided |
| 404 | Voucher not found | Voucher does not exist |
| 403 | Access denied | Not authorized to delete voucher |
| 409 | Voucher in use | Cannot delete voucher with active uses |

## Notes

- Deletion is permanent and cannot be undone
- Vouchers with usage history cannot be deleted (deactivate instead)
- Consider deactivating vouchers instead of deleting to preserve history
- Deleted voucher codes can be reused
