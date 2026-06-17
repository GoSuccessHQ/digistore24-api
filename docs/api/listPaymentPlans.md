# listPaymentPlans

Retrieves a list of all configured payment plans.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listPaymentPlans`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listPaymentPlans.yaml)

## Parameters

This endpoint takes no parameters. The request can be omitted entirely.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$response = $ds24->paymentPlans->list();

echo $response->result; // e.g. "success"

foreach ($response->paymentPlans as $plan) {
    echo $plan['paymentplan_id'];
}
```

You may also pass an explicit `ListPaymentPlansRequest`:

```php
use GoSuccess\Digistore24\Api\Request\PaymentPlan\ListPaymentPlansRequest;

$response = $ds24->paymentPlans->list(new ListPaymentPlansRequest());
```

## Response

`ListPaymentPlansResponse` exposes:

- `result` (string) — Result status returned by the API.
- `paymentPlans` (array<string, mixed>) — List of payment plans. Iterate and read each entry by key, e.g. `$plan['paymentplan_id']`.

## Error Handling

```php
try {
    $response = $ds24->paymentPlans->list();
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createPaymentplan](createPaymentplan.md)
- [updatePaymentplan](updatePaymentplan.md)
- [deletePaymentplan](deletePaymentplan.md)
