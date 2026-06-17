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
