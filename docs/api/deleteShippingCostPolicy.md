# deleteShippingCostPolicy

Deletes an existing shipping cost policy by its unique identifier.

## Endpoint

**DELETE** `https://www.digistore24.com/api/call/deleteShippingCostPolicy`

[OpenAPI spec](https://digistore24.com/api/docs/paths/deleteShippingCostPolicy.yaml)

## Parameters

- `shippingCostPolicyId` (string, required) — The unique identifier of the shipping cost policy to delete.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Shipping\DeleteShippingCostPolicyRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new DeleteShippingCostPolicyRequest(shippingCostPolicyId: '112233');

$response = $ds24->shipping->delete($request);

echo $response->result; // e.g. "success"
```

## Response

`DeleteShippingCostPolicyResponse` exposes:

- `result` (string) — Result status returned by the API.

## Error Handling

```php
try {
    $response = $ds24->shipping->delete($request);
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
- [listShippingCostPolicies](listShippingCostPolicies.md)
