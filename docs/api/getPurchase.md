# getPurchase

Retrieves detailed information about a specific purchase/order.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getPurchase`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getPurchase.yaml)

## Parameters

Constructor arguments of `GetPurchaseRequest`:

- `purchaseId` (string, required) — The Digistore24 order ID.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Purchase\GetPurchaseRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetPurchaseRequest(purchaseId: '12345678');

$response = $ds24->purchases->get($request);

echo $response->purchaseId;                    // e.g. "12345678"
echo $response->productName;                   // e.g. "Premium Course"
echo $response->amount . ' ' . $response->currency; // e.g. "99 EUR"
echo $response->buyerEmail;                    // e.g. "customer@example.com"
echo $response->billingStatus;                 // e.g. "completed"
echo $response->createdAt->format('Y-m-d');    // e.g. "2026-06-17"
```

## Response

`GetPurchaseResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `purchaseId` (string) — The order ID.
- `productId` (string) — The product ID.
- `productName` (string) — The product name.
- `buyerEmail` (string) — The buyer's email address.
- `paymentStatus` (string) — Payment status code.
- `billingStatus` (string) — Billing status code.
- `amount` (float) — The order amount.
- `currency` (string) — 3-letter currency code. Defaults to `EUR`.
- `createdAt` (DateTimeInterface) — When the order was created.
- `additionalData` (array) — Any further fields returned by the API.

## Error Handling

```php
try {
    $response = $ds24->purchases->get($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [listPurchases](listPurchases.md)
- [listPurchasesOfEmail](listPurchasesOfEmail.md)
- [getPurchaseTracking](getPurchaseTracking.md)
- [getPurchaseDownloads](getPurchaseDownloads.md)
