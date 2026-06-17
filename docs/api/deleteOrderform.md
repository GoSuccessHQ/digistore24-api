# deleteOrderform

Deletes an existing order form by its unique identifier.

## Endpoint

**DELETE** `https://www.digistore24.com/api/call/deleteOrderform`

[OpenAPI spec](https://digistore24.com/api/docs/paths/deleteOrderform.yaml)

## Parameters

`DeleteOrderformRequest` takes the following constructor argument:

- `orderformId` (string, required) — The unique identifier of the order form to delete.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\OrderForm\DeleteOrderformRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new DeleteOrderformRequest(orderformId: '456');

$response = $ds24->orderForms->delete($request);

echo $response->wasSuccessful() ? 'deleted' : 'failed';
```

## Response

`DeleteOrderformResponse` exposes:

- `result` (string) — Result status returned by the API.
- `wasSuccessful(): bool` — Returns `true` when `result === 'success'`.

## Error Handling

```php
use GoSuccess\Digistore24\Api\Exception\ValidationException;
use GoSuccess\Digistore24\Api\Exception\ApiException;

try {
    $response = $ds24->orderForms->delete($request);
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
- [listOrderforms](listOrderforms.md)
- [getOrderformMetas](getOrderformMetas.md)
