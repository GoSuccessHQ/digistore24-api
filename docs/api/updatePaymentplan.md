# updatePaymentplan

Updates an existing payment plan's configuration.

## Endpoint

**PUT** `https://www.digistore24.com/api/call/updatePaymentplan`

[OpenAPI spec](https://digistore24.com/api/docs/paths/updatePaymentplan.yaml)

## Parameters

- `paymentplanId` (string, required) — The unique identifier of the payment plan to update.
- `paymentPlan` (`PaymentPlanFullData`, required) — The updated payment plan configuration.

The `paymentPlan` argument wraps a `PaymentPlanFullData` DTO with the following settable properties:

- `firstAmount` (float, optional) — Amount of the first payment (>= 0).
- `firstBillingInterval` (string, optional) — Interval between purchase and the second payment. Examples: `4_day`, `1_week`, `1_month`, `3_month`, `6_month`, `12_month`.
- `currency` (string, optional) — 3-letter currency code (e.g. `USD`, `EUR`).
- `otherAmounts` (float, optional) — Amount for follow-up payments (>= 0).
- `otherBillingIntervals` (string, optional) — Interval for follow-up payments. Examples: `1_week`, `1_month`, `3_month`, `6_month`, `12_month`.
- `numberOfInstallments` (int, optional) — Number of installments (>= 0). `0` = subscription (indefinite), `1` = single payment, `>= 2` = installment plan.
- `testInterval` (string, optional) — Test/trial period interval (e.g. `7_day`).
- `startPayplanAt` (string, optional) — Fixed start date for the payment plan in `YYYY-MM-DD` format.
- `isActive` (bool, optional) — Whether the payment plan is active. Sent as `Y`/`N`.
- `position` (int, optional) — Display position of the payment plan (>= 0).
- `cancelPolicy` (string, optional) — Cancellation policy (minimum term) in the format `{minimum_term}m_{notice_period}m`. Allowed: `6m_0`, `6m_6m`, `6m_12m`, `12m_0`, `12m_3m`, `12m_6m`, `12m_12m`, `24m_0`, `24m_6m`, `24m_12m`.
- `isForSale` (string, optional) — Sale type: `all`, `new`, `upgrade`, or a comma-separated combination.
- `isSwitchingAllowed` (bool, optional) — Whether buyers may switch to/from this plan. Sent as `Y`/`N`.
- `canBuyerTerminateInstallments` (string, optional) — Termination rules. Allowed: `Y`, `N`, `N_subscription`.
- `isDiscountEnabled` (bool, optional) — Whether quantity discounts are enabled. Sent as `Y`/`N`.
- `discountUnitPrices` (array<int, `PaymentPlanDiscountTierData`>, optional) — Quantity-based pricing tiers (`fromQuantity`, `unitPrice1st`, `unitPriceOth`).

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\PaymentPlan\UpdatePaymentplanRequest;
use GoSuccess\Digistore24\Api\DTO\PaymentPlanFullData;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$paymentPlan = new PaymentPlanFullData();
$paymentPlan->currency = 'EUR';
$paymentPlan->firstAmount = 59.00;
$paymentPlan->otherAmounts = 39.00;
$paymentPlan->otherBillingIntervals = '1_month';
$paymentPlan->isActive = true;

$request = new UpdatePaymentplanRequest(
    paymentplanId: '789',
    paymentPlan: $paymentPlan,
);

$response = $ds24->paymentPlans->update($request);

echo $response->result;            // e.g. "success"
var_dump($response->modified);     // bool|null — whether changes were applied
```

## Response

`UpdatePaymentplanResponse` exposes:

- `result` (string) — Result status returned by the API.
- `modified` (?bool) — Whether changes were applied (spec key: `modified`, `Y`/`N`).
- `renderedTexts` (?`PaymentPlanRenderedTextsData`) — Rendered order-form texts with `headline`, `description` and `footnote`.
- `plan` (array<string, mixed>) — The full payment plan object as returned by the API.
- `data` (array<string, mixed>) — Raw response payload.

## Error Handling

```php
try {
    $response = $ds24->paymentPlans->update($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createPaymentplan](createPaymentplan.md)
- [deletePaymentplan](deletePaymentplan.md)
- [listPaymentPlans](listPaymentPlans.md)
