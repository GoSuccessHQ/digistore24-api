# startRebilling

Starts or resumes automatic rebilling for a purchase.

## Endpoint

**POST** `https://www.digistore24.com/api/call/startRebilling`

[OpenAPI spec](https://digistore24.com/api/docs/paths/startRebilling.yaml)

## Parameters

- `purchaseId` (string, required) — The unique identifier of the purchase whose rebilling should be started or resumed.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Rebilling\StartRebillingRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new StartRebillingRequest(purchaseId: 'ABCD1234');

$response = $ds24->rebilling->start($request);

echo $response->result;                       // e.g. "success"
echo $response->data?->rebillingActive;       // bool, true when rebilling is active
echo $response->data?->billingStatusMsg;      // human-readable status message
```

## Response

`StartRebillingResponse` exposes:

- `result` (string) — Result status returned by the API.
- `data` (`?RebillingData`) — Typed rebilling details, or `null` when the API returns no payload. Relevant properties:
  - `modified` (bool) — Whether rebilling was modified.
  - `note` (?string) — Note text on the outcome.
  - `billingStatus` (?string) — Current billing status.
  - `billingStatusMsg` (?string) — Human-readable billing status message.
  - `nextPaymentAt` (?DateTimeImmutable) — Date of the next payment.
  - `rebillingActive` (bool) — Whether rebilling is active.

## Error Handling

```php
try {
    $response = $ds24->rebilling->start($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [stopRebilling](stopRebilling.md)
- [createRebillingPayment](createRebillingPayment.md)
- [listRebillingStatusChanges](listRebillingStatusChanges.md)
