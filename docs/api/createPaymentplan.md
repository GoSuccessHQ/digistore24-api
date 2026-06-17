# createPaymentplan

Creates a new payment plan with installment configuration for a product.

## Endpoint

**POST** `https://www.digistore24.com/api/call/createPaymentplan`

[OpenAPI spec](https://digistore24.com/api/docs/paths/createPaymentplan.yaml)

## Parameters

The request takes two arguments:

- `productId` (int, required) — The product the payment plan belongs to.
- `paymentPlan` (`PaymentPlanFullData`, required) — The payment plan configuration.

The `paymentPlan` argument wraps a `PaymentPlanFullData` DTO with the following settable properties:

- `firstAmount` (float, optional) — Amount of the first payment (>= 0).
- `firstBillingInterval` (string, optional) — Interval between purchase and the second payment. Examples: `4_day`, `1_week`, `1_month`, `3_month`, `6_month`, `12_month`.
- `currency` (string, optional) — 3-letter currency code (e.g. `USD`, `EUR`).
- `otherAmounts` (float, optional) — Amount for follow-up payments (>= 0).
- `otherBillingIntervals` (string, optional) — Interval for follow-up payments. Examples: `1_week`, `1_month`, `3_month`, `6_month`, `12_month`.
- `numberOfInstallments` (int, optional) — Number of installments (>= 0). `0` = subscription (indefinite), `1` = single payment, `>= 2` = installment plan.
- `isActive` (bool, optional) — Whether the payment plan is active.
- `cancelPolicy` (string, optional) — Cancellation policy (minimum term) in the format `{minimum_term}m_{notice_period}m`. Allowed: `6m_0`, `6m_6m`, `6m_12m`, `12m_0`, `12m_3m`, `12m_6m`, `12m_12m`, `24m_0`, `24m_6m`, `24m_12m`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\PaymentPlan\CreatePaymentplanRequest;
use GoSuccess\Digistore24\Api\DTO\PaymentPlanFullData;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$paymentPlan = new PaymentPlanFullData();
$paymentPlan->currency = 'EUR';
$paymentPlan->firstAmount = 49.00;
$paymentPlan->firstBillingInterval = '1_month';
$paymentPlan->otherAmounts = 29.00;
$paymentPlan->otherBillingIntervals = '1_month';
$paymentPlan->numberOfInstallments = 0; // subscription
$paymentPlan->isActive = true;

$request = new CreatePaymentplanRequest(
    productId: 123,
    paymentPlan: $paymentPlan,
);

$response = $ds24->paymentPlans->create($request);

echo $response->result;              // e.g. "success"
echo $response->getPaymentplanId();  // e.g. "789"
```

## Response

`CreatePaymentplanResponse` exposes:

- `result` (string) — Result status returned by the API.
- `data` (array<string, mixed>) — Raw response payload. Read individual values by key, e.g. `$response->data['paymentplan_id']`.
- `getPaymentplanId(): ?string` — Convenience accessor returning the ID of the newly created payment plan.

## Error Handling

```php
try {
    $response = $ds24->paymentPlans->create($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [updatePaymentplan](updatePaymentplan.md)
- [deletePaymentplan](deletePaymentplan.md)
- [listPaymentPlans](listPaymentPlans.md)
