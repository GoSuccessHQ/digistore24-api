# deletePaymentplan

Deletes an existing payment plan by its unique identifier.

## Endpoint

**DELETE** `https://www.digistore24.com/api/call/deletePaymentplan`

[OpenAPI spec](https://digistore24.com/api/docs/paths/deletePaymentplan.yaml)

## Parameters

- `paymentplanId` (string, required) — The unique identifier of the payment plan to delete.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\PaymentPlan\DeletePaymentplanRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new DeletePaymentplanRequest(paymentplanId: '789');

$response = $ds24->paymentPlans->delete($request);

echo $response->result; // e.g. "success"
```

## Response

`DeletePaymentplanResponse` exposes:

- `result` (string) — Result status returned by the API.

## Error Handling

```php
try {
    $response = $ds24->paymentPlans->delete($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createPaymentplan](createPaymentplan.md)
- [updatePaymentplan](updatePaymentplan.md)
- [listPaymentPlans](listPaymentPlans.md)
