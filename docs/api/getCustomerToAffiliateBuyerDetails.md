# getCustomerToAffiliateBuyerDetails

Returns details of the customer-to-affiliate program for specific buyer(s), including the affiliate registration URL and promotion URL.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getCustomerToAffiliateBuyerDetails`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getCustomerToAffiliateBuyerDetails.yaml)

The customer-to-affiliate program must be set up in Digistore24 first.

## Parameters

Constructor arguments of `GetCustomerToAffiliateBuyerDetailsRequest`:

- `purchaseId` (string, required) — A single Digistore24 order ID or a comma-separated list of order IDs.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Purchase\GetCustomerToAffiliateBuyerDetailsRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetCustomerToAffiliateBuyerDetailsRequest(purchaseId: '12345678');

$response = $ds24->purchases->getCustomerToAffiliateDetails($request);

foreach ($response->details as $purchaseId => $details) {
    echo $details['customer_affiliate_name'] ?? '';
    echo $details['customer_to_affiliate_url'] ?? '';
    echo $details['customer_affiliate_promo_url'] ?? '';
}
```

## Response

`GetCustomerToAffiliateBuyerDetailsResponse` exposes:

- `result` (string) — Result status returned by the API.
- `details` (array) — Affiliate program details keyed by purchase ID. Each entry contains keys such as `customer_affiliate_name`, `customer_to_affiliate_url`, and `customer_affiliate_promo_url`.

## Error Handling

```php
try {
    $response = $ds24->purchases->getCustomerToAffiliateDetails($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getPurchase](getPurchase.md)
- [listPurchases](listPurchases.md)
- [listPurchasesOfEmail](listPurchasesOfEmail.md)
