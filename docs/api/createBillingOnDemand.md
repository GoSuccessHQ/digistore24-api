# createBillingOnDemand

Creates a customized order that reuses the payment method from a reference purchase, so the buyer does not have to re-enter their payment details.

## Endpoint

**POST** `https://www.digistore24.com/api/call/createBillingOnDemand`

[OpenAPI spec](https://digistore24.com/api/docs/paths/createBillingOnDemand.yaml)

Requirements:
- The "Billing on demand" right must be enabled for the vendor account.
- The reference purchase must use a payment method that supports rebilling.

## Parameters

Constructor arguments of `CreateBillingOnDemandRequest`:

- `purchaseId` (string, required) — The reference order ID whose payment method is reused. Must support rebilling.
- `productId` (string, required) — The product ID in Digistore24 to bill.
- `paymentPlan` (array, optional) — Payment plan configuration (e.g. `first_amount`, `other_amounts`, `currency`).
- `tracking` (array, optional) — Tracking data such as `custom`, `affiliate`, `campaignkey`, `trackingkey`.
- `placeholders` (array, optional) — Placeholders for the product title and description.
- `settings` (array, optional) — Additional settings such as `voucher_code`, `quantity`, `product_country`.
- `addons` (array, optional) — List of add-on products.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Billing\CreateBillingOnDemandRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new CreateBillingOnDemandRequest(
    purchaseId: '12345678',
    productId: '987654',
    paymentPlan: [
        'first_amount' => 49.0,
        'other_amounts' => 19.0,
        'currency' => 'EUR',
    ],
    tracking: [
        'custom' => 'newsletter-2026',
    ],
);

$response = $ds24->billing->createOnDemand($request);

echo $response->createdPurchaseId; // e.g. "23456789"
echo $response->paymentStatusMsg;  // e.g. "The payment was successful."
```

## Response

`CreateBillingOnDemandResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `createdPurchaseId` (string) — ID of the newly created order.
- `paymentStatus` (string) — Payment status code.
- `paymentStatusMsg` (string) — Payment status in human-readable form.
- `billingStatus` (string) — Billing status code.
- `billingStatusMsg` (string) — Billing status in human-readable form.

## Error Handling

```php
try {
    $response = $ds24->billing->createOnDemand($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createAddonChangePurchase](createAddonChangePurchase.md)
- [createUpgradePurchase](createUpgradePurchase.md)
- [getPurchase](getPurchase.md)
- [refundPartially](refundPartially.md)
