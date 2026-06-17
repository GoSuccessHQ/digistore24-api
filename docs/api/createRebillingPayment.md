# createRebillingPayment

Creates a manual rebilling payment for a recurring subscription.

## Endpoint

**POST** `https://www.digistore24.com/api/call/createRebillingPayment`

[OpenAPI spec](https://digistore24.com/api/docs/paths/createRebillingPayment.yaml)

## Parameters

- `purchaseId` (string, required) — The unique identifier of the purchase with an active subscription.
- `data` (array, optional) — Additional payment data merged into the request (for example `amount`, `currency`, `note`). Defaults to `[]`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Rebilling\CreateRebillingPaymentRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new CreateRebillingPaymentRequest(
    purchaseId: 'ABCD1234',
    data: [
        'amount' => 29.00,
        'currency' => 'EUR',
    ],
);

$response = $ds24->rebilling->createPayment($request);

echo $response->result; // e.g. "success"
```

## Response

`CreateRebillingPaymentResponse` exposes:

- `result` (string) — Result status returned by the API.
- `purchaseId` (?string) — The order ID (same as the input parameter).
- `paymentStatus` (`?BillingPaymentStatus`) — Status of the payment attempt: `COMPLETED`, `PENDING`, `UNCERTAIN`, `REFUSED`, `ERROR`.
- `paymentMessage` (?string) — Error message in case of payment failure.
- `billingStatus` (?string) — Current state of the billing cycle (`paying`, `aborted`, `unpaid`, `completed`, `payment_data_update_required`).
- `paymentDataUpdateUrl` (?string) — URL where the buyer can update their payment information.
- `data` (array) — The complete inner payload, accessible by key.

## Error Handling

```php
try {
    $response = $ds24->rebilling->createPayment($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [startRebilling](startRebilling.md)
- [stopRebilling](stopRebilling.md)
- [listRebillingStatusChanges](listRebillingStatusChanges.md)
