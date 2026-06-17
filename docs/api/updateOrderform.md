# updateOrderform

Updates the configuration of an existing order form.

## Endpoint

**PUT** `https://www.digistore24.com/api/call/updateOrderform`

[OpenAPI spec](https://digistore24.com/api/docs/paths/updateOrderform.yaml)

## Parameters

`UpdateOrderformRequest` takes the following constructor arguments:

- `orderformId` (string, required) — The unique identifier of the order form to update.
- `orderForm` (`OrderFormData`, required) — The updated configuration. Populate only the settable properties you want to change (all optional). Validated properties throw `\InvalidArgumentException` on assignment if invalid:
  - `name` (string) — Name of the order form. Must not exceed 63 characters.
  - `layout` (string) — Layout type. Allowed: `widget`, `legacy`.
  - `backgroundStyle` (string) — Background style. Allowed: `white`, `blue`.
  - `stepCount` (int) — Number of steps/tabs. Allowed: `1`, `2`, `3`.
  - `shippingPosition` (string) — Position of shipping details. Allowed: `after_cart`, `before_cart`.
  - `tabStyle` (string) — Style of tabs. Allowed: `bigtabs`, `image`, `image_url`.
  - `orderBumpStyle` (string) — Order bump display style. Allowed: `none`, `dashed`.
  - `orderbumpPosition` / `refundWaiverPosition` (string) — Allowed: `before_playplan`, `after_payplan`, `before_checkout`, `before_pay_button`, `after_pay_button`.
  - `customCss` (string) — Custom CSS for the order form.

  See [createOrderform](createOrderform.md) for the full list of `OrderFormData` properties.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\OrderForm\UpdateOrderformRequest;
use GoSuccess\Digistore24\Api\DTO\OrderFormData;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$orderForm = new OrderFormData();
$orderForm->name = 'Updated Checkout';
$orderForm->backgroundStyle = 'blue';

$request = new UpdateOrderformRequest(
    orderformId: '456',
    orderForm: $orderForm,
);

$response = $ds24->orderForms->update($request);

echo $response->wasSuccessful() ? 'updated' : 'failed';
```

## Response

`UpdateOrderformResponse` exposes:

- `result` (string) — Result status returned by the API.
- `wasSuccessful(): bool` — Returns `true` when `result === 'success'`.

## Error Handling

```php
use GoSuccess\Digistore24\Api\Exception\ValidationException;
use GoSuccess\Digistore24\Api\Exception\ApiException;

try {
    $response = $ds24->orderForms->update($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

Note: assigning a disallowed value to the DTO (for example `backgroundStyle = 'green'`) throws an `\InvalidArgumentException` immediately, before the request is sent.

## Related Endpoints

- [createOrderform](createOrderform.md)
- [getOrderform](getOrderform.md)
- [deleteOrderform](deleteOrderform.md)
- [listOrderforms](listOrderforms.md)
- [getOrderformMetas](getOrderformMetas.md)
