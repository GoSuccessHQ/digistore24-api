# createOrderform

Creates a new order form (checkout page) with the given configuration.

## Endpoint

**POST** `https://www.digistore24.com/api/call/createOrderform`

[OpenAPI spec](https://digistore24.com/api/docs/paths/createOrderform.yaml)

## Parameters

`CreateOrderformRequest` wraps an `OrderFormData` DTO. Populate the settable properties you need before passing it to the request (all are optional; validated values throw `\InvalidArgumentException` on assignment if invalid):

- `name` (string) — Name of the order form. Must not exceed 63 characters.
- `layout` (string) — Layout type. Allowed: `widget`, `legacy`.
- `backgroundStyle` (string) — Background style. Allowed: `white`, `blue`.
- `stepCount` (int) — Number of steps/tabs. Allowed: `1`, `2`, `3`.
- `shippingPosition` (string) — Position of shipping details relative to the cart. Allowed: `after_cart`, `before_cart`.
- `summaryPositions` (string) — Comma-separated positions for purchase order summaries.
- `flexElementsOrder` (string) — Order of flex elements (order bump, summary, refund waiver).
- `tabStyle` (string) — Style of tabs. Allowed: `bigtabs`, `image`, `image_url`.
- `tabText1Hl`, `tabText1Sl`, `tabText2Hl`, `tabText2Sl`, `tabText3Hl`, `tabText3Sl` (string) — Tab headlines/subtitles for `bigtabs`.
- `tabImage1Id`, `tabImage2Id`, `tabImage3Id` (string) — Tab image IDs.
- `tabImage1Url`, `tabImage2Url`, `tabImage3Url` (string) — Tab image URLs.
- `orderBumpStyle` (string) — Order bump display style. Allowed: `none`, `dashed`.
- `orderbumpProductId` (string) — Product ID for the order bump (must be an addon of the main product).
- `orderbumpHeadline` (string) — Headline for the order bump.
- `orderbumpHtml` (string) — Text/HTML content for the order bump.
- `orderbumpPosition` (string) — Position of the order bump. Allowed: `before_playplan`, `after_payplan`, `before_checkout`, `before_pay_button`, `after_pay_button`.
- `refundWaiverPosition` (string) — Position of the refund waiver. Allowed: `before_playplan`, `after_payplan`, `before_checkout`, `before_pay_button`, `after_pay_button`.
- `customCss` (string) — Custom CSS for the order form.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\OrderForm\CreateOrderformRequest;
use GoSuccess\Digistore24\Api\DTO\OrderFormData;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$orderForm = new OrderFormData();
$orderForm->name = 'Premium Checkout';
$orderForm->layout = 'widget';
$orderForm->backgroundStyle = 'white';
$orderForm->stepCount = 2;

$request = new CreateOrderformRequest(orderForm: $orderForm);

$response = $ds24->orderForms->create($request);

echo $response->getOrderformId(); // e.g. "456"
echo $response->wasSuccessful() ? 'created' : 'failed';
```

## Response

`CreateOrderformResponse` exposes:

- `result` (string) — Result status returned by the API.
- `data` (array) — Raw response payload. Read individual values by key, e.g. `$response->data['orderform_id']`.
- `getOrderformId(): ?string` — Convenience accessor for the new order form ID.
- `wasSuccessful(): bool` — Returns `true` when `result === 'success'`.

## Error Handling

```php
use GoSuccess\Digistore24\Api\Exception\ValidationException;
use GoSuccess\Digistore24\Api\Exception\ApiException;

try {
    $response = $ds24->orderForms->create($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

Note: assigning a disallowed value to the DTO (for example `layout = 'fancy'` or a `name` longer than 63 characters) throws an `\InvalidArgumentException` immediately, before the request is sent.

## Related Endpoints

- [getOrderform](getOrderform.md)
- [updateOrderform](updateOrderform.md)
- [deleteOrderform](deleteOrderform.md)
- [listOrderforms](listOrderforms.md)
- [getOrderformMetas](getOrderformMetas.md)
