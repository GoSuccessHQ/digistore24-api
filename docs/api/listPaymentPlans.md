# listPaymentPlans

Retrieves the list of payment plans configured for a product.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listPaymentPlans`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listPaymentPlans.yaml)

## Parameters

| Name | Type | Required | Description |
| --- | --- | --- | --- |
| `product_id` | int | Yes | The Digistore24 product ID whose payment plans to list. |

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

// Pass the product ID directly.
$response = $ds24->paymentPlans->list(12345);

echo $response->result; // e.g. "success"

foreach ($response->paymentPlans as $plan) {
    echo $plan->id;          // payment plan ID
    echo $plan->productId;   // associated product ID
    echo $plan->name;        // payment plan name
    echo $plan->createdAt?->format('Y-m-d H:i:s');
    echo $plan->modifiedAt?->format('Y-m-d H:i:s');
}
```

You may also pass an explicit `ListPaymentPlansRequest`:

```php
use GoSuccess\Digistore24\Api\Request\PaymentPlan\ListPaymentPlansRequest;

$response = $ds24->paymentPlans->list(new ListPaymentPlansRequest(productId: 12345));
```

## Response

`ListPaymentPlansResponse` exposes:

- `result` (string) — Result status returned by the API.
- `paymentPlans` (array<int, PaymentPlanListItemData>) — List of payment plans as typed DTOs.

Each `PaymentPlanListItemData` exposes:

- `id` (?int) — Payment plan ID.
- `productId` (?int) — Associated product ID.
- `name` (?string) — Payment plan name.
- `createdAt` (?DateTimeImmutable) — Creation timestamp.
- `modifiedAt` (?DateTimeImmutable) — Last modification timestamp.

## Error Handling

```php
try {
    $response = $ds24->paymentPlans->list(12345);
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
