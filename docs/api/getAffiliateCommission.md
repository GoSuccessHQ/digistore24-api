# getAffiliateCommission

Get affiliate commission settings for one or more products.

## Endpoint

```
GET /getAffiliateCommission
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `affiliate_id` | string | Yes | Affiliate ID to get commission settings for |
| `product_ids` | string | No | Product IDs (comma-separated) or "all" for all products (default: "all") |

## Response Fields

| Field | Type | Description |
|-------|------|-------------|
| `affiliations` | array | Array of affiliation commission data |
| `affiliate_id` | string | Affiliate ID |
| `affiliate_name` | string | Affiliate name |

### Affiliation Object

| Field | Type | Description |
|-------|------|-------------|
| `commission_rate` | string | Commission rate as percentage |
| `commission_currency` | string | Currency code for commission |
| `default_commission_rate` | string | Default commission rate as percentage |
| `default_commission_fix` | string | Default fixed commission amount |
| `default_commission_currency` | string | Default commission currency code |
| `commission_fix` | string | Fixed commission amount |
| `is_on_first_pmnt_only` | string | Whether commission applies only to first payment (Y/N or empty) |
| `product_id` | string | Product ID |
| `product_is_active` | string | Whether product is active (Y/N) |
| `approval_status` | string | Approval status: "new", "approved", "rejected", "pending" |
| `approval_status_msg` | string | Human-readable approval status message |

## Response Structure (PHP)

```php
GetAffiliateCommissionResponse {
  +affiliations: array<AffiliationData> [
    AffiliationData {
      +commissionRate: string
      +commissionCurrency: string
      +defaultCommissionRate: string
      +defaultCommissionFix: string
      +defaultCommissionCurrency: string
      +commissionFix: string
      +isOnFirstPmntOnly: bool
      +productId: string
      +productIsActive: bool
      +approvalStatus: AffiliateApprovalStatus
      +approvalStatusMsg: string
    }
  ]
  +affiliateId: string
  +affiliateName: string
}
```

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Affiliate\GetAffiliateCommissionRequest;

$config = new Configuration('YOUR-API-KEY');
$api = new Digistore24($config);

// Get commission settings for all products
$request = new GetAffiliateCommissionRequest(
    affiliateId: 'GoSuccess',
    productIds: 'all'
);
$response = $api->affiliates->getCommission($request);

// Access response data
echo "Affiliate: {$response->affiliateName} (ID: {$response->affiliateId})\n";
echo "Total Products: " . count($response->affiliations) . "\n\n";

foreach ($response->affiliations as $affiliation) {
    echo "Product {$affiliation->productId}:\n";
    echo "  Commission: {$affiliation->commissionRate}% {$affiliation->commissionCurrency}\n";
    echo "  Status: {$affiliation->approvalStatus->value} - {$affiliation->approvalStatusMsg}\n";
    echo "  Active: " . ($affiliation->productIsActive ? 'Yes' : 'No') . "\n\n";
}

// Get commission settings for specific products
$request = new GetAffiliateCommissionRequest(
    affiliateId: 'GoSuccess',
    productIds: '406040,406042,406043'
);
$response = $api->affiliates->getCommission($request);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 401 | Unauthorized | Invalid or missing API key |
| 403 | Forbidden | Insufficient access rights |
| 404 | Not found | Affiliate not found |

## Notes

- Commission rates are returned as decimal strings (e.g., "50.00")
- Use `product_ids=all` to retrieve all products
- Use comma-separated product IDs for specific products
- Empty `default_commission_currency` means no default currency is set
- Empty `is_on_first_pmnt_only` is treated as false (commission on all payments)
- Use `updateAffiliateCommission` to modify settings
