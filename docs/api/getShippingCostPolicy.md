# getShippingCostPolicy

Retrieves detailed information about a specific shipping cost policy.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getShippingCostPolicy`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getShippingCostPolicy.yaml)

## Parameters

- `shippingCostPolicyId` (string, required) — The unique identifier of the shipping cost policy.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Shipping\GetShippingCostPolicyRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetShippingCostPolicyRequest(shippingCostPolicyId: '112233');

$response = $ds24->shipping->get($request);

echo $response->result;                      // e.g. "success"
echo $response->shippingCostPolicy['name']; // e.g. "Standard Shipping"
```

## Response

`GetShippingCostPolicyResponse` exposes:

- `result` (string) — Result status returned by the API.
- `shippingCostPolicy` (array<string, mixed>) — The shipping cost policy details. Read individual values by key, e.g. `$response->shippingCostPolicy['name']`.

## Error Handling

```php
try {
    $response = $ds24->shipping->get($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createShippingCostPolicy](createShippingCostPolicy.md)
- [updateShippingCostPolicy](updateShippingCostPolicy.md)
- [deleteShippingCostPolicy](deleteShippingCostPolicy.md)
- [listShippingCostPolicies](listShippingCostPolicies.md)
