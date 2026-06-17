# getOrderformMetas

Retrieves metadata and the available configuration options for order forms.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getOrderformMetas`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getOrderformMetas.yaml)

## Parameters

`GetOrderformMetasRequest` takes no constructor arguments. The resource method accepts an optional request, so you can also call `getMetas()` with no arguments.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$response = $ds24->orderForms->getMetas();

// Inspect the available metadata options
var_dump($response->data);
```

You may also pass an explicit request instance:

```php
use GoSuccess\Digistore24\Api\Request\OrderForm\GetOrderformMetasRequest;

$response = $ds24->orderForms->getMetas(new GetOrderformMetasRequest());
```

## Response

`GetOrderformMetasResponse` exposes:

- `result` (string) — Result status returned by the API.
- `data` (array) — Raw metadata payload. Read individual values by key, e.g. `$response->data['layouts']`.

## Error Handling

```php
use GoSuccess\Digistore24\Api\Exception\ValidationException;
use GoSuccess\Digistore24\Api\Exception\ApiException;

try {
    $response = $ds24->orderForms->getMetas();
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
- [listOrderforms](listOrderforms.md)
