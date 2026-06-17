# getPurchaseDownloads

Get download information for purchased digital products including URLs, limits, and file details.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getPurchaseDownloads`

## OpenAPI Specification

[View OpenAPI Spec](https://digistore24.com/api/docs/paths/getPurchaseDownloads.yaml)

## Parameters

### Required Parameters

- `purchase_id` (string) - Single Digistore24 order ID or comma-separated list of order IDs

## Response

```json
{
  "downloads": {
    "ABCD-1234": {
      "12345": [
        {
          "url": "https://download.digistore24.com/...",
          "downloads_total": 5,
          "downloads_tries": 2,
          "is_access_granted": "Y",
          "is_purchase_paid": "Y",
          "headline": "E-Book Download",
          "instructions": "Right-click and save",
          "file_name": "ebook.pdf",
          "file_ext": "pdf",
          "file_size": 1024000,
          "download_until": "2025-12-31"
        }
      ]
    }
  }
}
```

## Usage Example

```php
use Digistore24\Request\Purchase\GetPurchaseDownloadsRequest;

$request = new GetPurchaseDownloadsRequest(
    purchaseId: 'ABCD-1234-EFGH'
);

$response = $digistore24->purchases->getDownloads($request);

foreach ($response->downloads as $purchaseId => $products) {
    echo "Purchase: {$purchaseId}\n";
    
    foreach ($products as $productId => $files) {
        echo "  Product: {$productId}\n";
        
        foreach ($files as $file) {
            $remaining = $file['downloads_total'] - $file['downloads_tries'];
            $hasAccess = $file['is_access_granted'] === 'Y';
            echo "    File: {$file['file_name']}\n";
            echo "    URL: {$file['url']}\n";
            echo "    Remaining: {$remaining} downloads\n";
            echo "    Access: " . ($hasAccess ? 'Yes' : 'No') . "\n";
        }
    }
}
```

## Check Download Status

```php
$request = new GetPurchaseDownloadsRequest(purchaseId: 'ABCD-1234');
$response = $digistore24->purchases->getDownloads($request);

$downloads = $response->downloads['ABCD-1234'] ?? [];

foreach ($downloads as $productId => $files) {
    foreach ($files as $file) {
        $remaining = $file['downloads_total'] - $file['downloads_tries'];
        if ($file['is_access_granted'] !== 'Y') {
            echo "Access denied for {$file['file_name']}";
        } elseif ($file['is_purchase_paid'] !== 'Y') {
            echo "Payment pending for {$file['file_name']}";
        } elseif ($remaining === 0) {
            echo "Download limit reached for {$file['file_name']}";
        }
    }
}
```

## Important Notes

- **Download Limits**: Track remaining downloads with `getRemainingDownloads()`
- **Access Control**: Check `hasAccess()` and `isPaid()` before providing links
- **Expiration**: Downloads may expire based on `download_until` date
- **Multiple Purchases**: Supports comma-separated purchase IDs

## Related Endpoints

- [getPurchase](getPurchase.md) - Get full purchase details
- [listPurchases](listPurchases.md) - List all purchases
