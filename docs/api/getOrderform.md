# getOrderform

Retrieves detailed information about a specific order form.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getOrderform`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getOrderform.yaml)

## Parameters

`GetOrderformRequest` takes the following constructor argument:

- `orderformId` (string, required) — The unique identifier of the order form.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\OrderForm\GetOrderformRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetOrderformRequest(orderformId: '456');

$response = $ds24->orderForms->get($request);

echo $response->data['name'];   // e.g. "Premium Checkout"
echo $response->data['layout']; // e.g. "widget"
```

## Response

`GetOrderformResponse` exposes:

- `result` (string) — Result status returned by the API.
- `data` (array) — Raw order form payload. Read individual values by key, e.g. `$response->data['orderform_id']`, `$response->data['name']`, `$response->data['layout']`.

## Error Handling

```php
use GoSuccess\Digistore24\Api\Exception\ValidationException;
use GoSuccess\Digistore24\Api\Exception\ApiException;

try {
    $response = $ds24->orderForms->get($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createOrderform](createOrderform.md)
- [updateOrderform](updateOrderform.md)
- [deleteOrderform](deleteOrderform.md)
- [listOrderforms](listOrderforms.md)
- [getOrderformMetas](getOrderformMetas.md)
