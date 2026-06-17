# getPurchaseTracking

Get tracking data for one or more purchases including UTM parameters, click IDs, and campaign information.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getPurchaseTracking`

## OpenAPI Specification

[View OpenAPI Spec](https://digistore24.com/api/docs/paths/getPurchaseTracking.yaml)

## Parameters

### Required Parameters

- `purchase_id` (string) - Single Digistore24 order ID or comma-separated list of order IDs

## Response

```json
{
  "ABCD-1234": {
    "data": {
      "utm_params": {
        "utm_source": "google",
        "utm_medium": "cpc",
        "utm_campaign": "spring_sale",
        "utm_term": "online_course",
        "utm_content": "ad_variation_1"
      },
      "click_id": "gclid_123456789",
      "sub_ids": ["sub1_value", "sub2_value"],
      "vendor_key": "vendor_123",
      "campaign_key": "campaign_456"
    }
  }
}
```

## Usage Example

```php
use Digistore24\Request\Purchase\GetPurchaseTrackingRequest;

$request = new GetPurchaseTrackingRequest(
    purchaseId: 'ABCD-1234-EFGH'
);

$response = $digistore24->purchases->getTracking($request);

foreach ($response->tracking as $purchaseId => $tracking) {
    echo "Purchase: {$purchaseId}\n";
    echo "UTM Source: {$tracking->utmParams['utm_source']}\n";
    echo "UTM Campaign: {$tracking->utmParams['utm_campaign']}\n";
    echo "Click ID: {$tracking->clickId}\n";
}
```

## Multiple Purchases

```php
$request = new GetPurchaseTrackingRequest(
    purchaseId: 'ABCD-1234,WXYZ-5678,IJKL-9012'
);

$response = $digistore24->purchases->getTracking($request);
echo "Retrieved tracking for " . count($response->tracking) . " purchases";
```

## Related Endpoints

- [getPurchase](getPurchase.md) - Get full purchase details
- [listPurchases](listPurchases.md) - List purchases with tracking data
