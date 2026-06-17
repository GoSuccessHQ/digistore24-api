# listShippingCostPolicies

Retrieves a list of all shipping cost policies.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listShippingCostPolicies`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listShippingCostPolicies.yaml)

## Parameters

This endpoint takes no parameters. The request can be omitted entirely.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$response = $ds24->shipping->list();

echo $response->result; // e.g. "success"

foreach ($response->shippingCostPolicies as $policy) {
    echo $policy['name'];
}
```

You may also pass an explicit `ListShippingCostPoliciesRequest`:

```php
use GoSuccess\Digistore24\Api\Request\Shipping\ListShippingCostPoliciesRequest;

$response = $ds24->shipping->list(new ListShippingCostPoliciesRequest());
```

## Response

`ListShippingCostPoliciesResponse` exposes:

- `result` (string) — Result status returned by the API.
- `shippingCostPolicies` (array<string, mixed>) — List of shipping cost policies. Iterate and read each entry by key, e.g. `$policy['name']`.

## Error Handling

```php
try {
    $response = $ds24->shipping->list();
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createShippingCostPolicy](createShippingCostPolicy.md)
- [getShippingCostPolicy](getShippingCostPolicy.md)
- [updateShippingCostPolicy](updateShippingCostPolicy.md)
- [deleteShippingCostPolicy](deleteShippingCostPolicy.md)
