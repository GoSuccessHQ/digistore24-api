# createShippingCostPolicy

Creates a new shipping cost policy for physical product delivery.

## Endpoint

**POST** `https://www.digistore24.com/api/call/createShippingCostPolicy`

[OpenAPI spec](https://digistore24.com/api/docs/paths/createShippingCostPolicy.yaml)

## Parameters

The request wraps a `ShippingCostPolicyData` DTO. Populate the following settable properties before passing it to the request:

- `name` (string, required) — Name of the shipping cost policy. Must not exceed 63 characters.
- `labels` (array<string, string>, optional) — Order-form labels keyed by two-letter language code (e.g. `['en' => 'Shipping', 'de' => 'Versand']`). Each label may be at most 63 characters.
- `position` (int, optional) — Display position. Must be positive. Defaults to `100`.
- `isActive` (bool, optional) — Whether the policy is active. Defaults to `true`.
- `forProductIds` (string, optional) — Comma-separated list of product IDs the policy applies to. Defaults to `"all"`.
- `forCountries` (string, optional) — Comma-separated list of ISO country codes (e.g. `US,DE`). Defaults to `"all"`.
- `forCurrencies` (string, optional) — Comma-separated list of currency codes (e.g. `USD,EUR`). Defaults to `"all"`.
- `feeType` (string, optional) — Type of fee calculation: `total_fee` or `fee_per_unit`. Defaults to `total_fee`.
- `billingCycle` (string, optional) — When the fee is charged: `once` or `monthly`. Defaults to `once`.
- `currency` (string, optional) — 3-letter currency code for the fees (e.g. `USD`, `EUR`).
- `scaleLevelCount` (int, optional) — Number of discount levels (1–5). Defaults to `1`.
- `scale1Amount` (float, optional) — Base shipping cost amount (>= 0).
- `scale2From` (int, optional) — Number of items for the second discount level.
- `scale2Amount` (float, optional) — Shipping cost for `scale2From` or more items (>= 0).
- `scale3From` (int, optional) — Number of items for the third discount level.
- `scale3Amount` (float, optional) — Shipping cost for `scale3From` or more items (>= 0).
- `scale4From` (int, optional) — Number of items for the fourth discount level.
- `scale4Amount` (float, optional) — Shipping cost for `scale4From` or more items (>= 0).
- `scale5From` (int, optional) — Number of items for the fifth discount level.
- `scale5Amount` (float, optional) — Shipping cost for `scale5From` or more items (>= 0).

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Shipping\CreateShippingCostPolicyRequest;
use GoSuccess\Digistore24\Api\DTO\ShippingCostPolicyData;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$policy = new ShippingCostPolicyData();
$policy->name = 'Standard Shipping';
$policy->labels = ['en' => 'Shipping', 'de' => 'Versand'];
$policy->currency = 'EUR';
$policy->scale1Amount = 4.95;
$policy->scaleLevelCount = 2;
$policy->scale2From = 5;
$policy->scale2Amount = 2.95;

$request = new CreateShippingCostPolicyRequest(policy: $policy);

$response = $ds24->shipping->create($request);

echo $response->result;                     // e.g. "success"
echo $response->getShippingCostPolicyId();  // e.g. "112233"
```

## Response

`CreateShippingCostPolicyResponse` exposes:

- `result` (string) — Result status returned by the API.
- `data` (array<string, mixed>) — Raw response payload. Read individual values by key, e.g. `$response->data['shipping_cost_policy_id']`.
- `getShippingCostPolicyId(): ?string` — Convenience accessor returning the ID of the newly created policy.

## Error Handling

```php
try {
    $response = $ds24->shipping->create($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getShippingCostPolicy](getShippingCostPolicy.md)
- [updateShippingCostPolicy](updateShippingCostPolicy.md)
- [deleteShippingCostPolicy](deleteShippingCostPolicy.md)
- [listShippingCostPolicies](listShippingCostPolicies.md)
