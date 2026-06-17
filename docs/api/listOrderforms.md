# listOrderforms

Retrieves a list of all order forms.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listOrderforms`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listOrderforms.yaml)

## Parameters

`ListOrderformsRequest` takes no constructor arguments. The resource method accepts an optional request, so you can also call `list()` with no arguments.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$response = $ds24->orderForms->list();

foreach ($response->orderforms as $orderform) {
    echo $orderform['orderform_id']; // e.g. "456"
    echo $orderform['name'];         // e.g. "Premium Checkout"
}
```

You may also pass an explicit request instance:

```php
use GoSuccess\Digistore24\Api\Request\OrderForm\ListOrderformsRequest;

$response = $ds24->orderForms->list(new ListOrderformsRequest());
```

## Response

`ListOrderformsResponse` exposes:

- `result` (string) — Result status returned by the API.
- `orderforms` (array) — List of order forms. Each entry is an associative array; read values by key, e.g. `$orderform['orderform_id']`, `$orderform['name']`.

## Error Handling

```php
use GoSuccess\Digistore24\Api\Exception\ValidationException;
use GoSuccess\Digistore24\Api\Exception\ApiException;

try {
    $response = $ds24->orderForms->list();
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createOrderform](createOrderform.md)
- [getOrderform](getOrderform.md)
- [updateOrderform](updateOrderform.md)
- [deleteOrderform](deleteOrderform.md)
- [getOrderformMetas](getOrderformMetas.md)
