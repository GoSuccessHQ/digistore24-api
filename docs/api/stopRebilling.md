# stopRebilling

Stops automatic rebilling for a purchase or subscription.

## Endpoint

**POST** `https://www.digistore24.com/api/call/stopRebilling`

[OpenAPI spec](https://digistore24.com/api/docs/paths/stopRebilling.yaml)

## Parameters

- `purchaseId` (string, required) — The unique identifier of the purchase whose rebilling should be stopped.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Rebilling\StopRebillingRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new StopRebillingRequest(purchaseId: 'ABCD1234');

$response = $ds24->rebilling->stop($request);

echo $response->result;                     // e.g. "success"
echo $response->data?->billingStatusMsg;    // human-readable status message
echo $response->data?->canCancelBefore;     // earliest possible cancellation date
```

## Response

`StopRebillingResponse` exposes:

- `result` (string) — Result status returned by the API.
- `data` (`?RebillingData`) — Typed rebilling details including cancellation information, or `null` when the API returns no payload. Relevant properties:
  - `modified` (bool) — Whether rebilling was modified.
  - `note` (?string) — Note text on the outcome.
  - `code` (?string) — Code indicating the outcome.
  - `billingStatus` (?string) — Current billing status.
  - `billingStatusMsg` (?string) — Human-readable billing status message.
  - `nextPaymentAt` (?DateTimeImmutable) — Date of the next payment.
  - `rebillingActive` (bool) — Whether rebilling is still active.
  - `isCancelledNow` (?bool) — Whether the order is canceled immediately.
  - `isCancelledLater` (?bool) — Whether the order is canceled later.
  - `canCancelBefore` (?string) — Earliest possible cancellation date.

## Error Handling

```php
try {
    $response = $ds24->rebilling->stop($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [startRebilling](startRebilling.md)
- [createRebillingPayment](createRebillingPayment.md)
- [listRebillingStatusChanges](listRebillingStatusChanges.md)
