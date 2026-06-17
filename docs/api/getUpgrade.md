# getUpgrade

Retrieves detailed information about a specific upgrade path.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getUpgrade`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getUpgrade.yaml)

## Parameters

- `upgradeId` (string, required) — The unique identifier of the upgrade to retrieve.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Upgrade\GetUpgradeRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetUpgradeRequest(upgradeId: '789');

$response = $ds24->upgrades->get($request);

echo $response->result;        // e.g. "success"
echo $response->data['name'];  // e.g. "Basic to Premium"
```

## Response

`GetUpgradeResponse` exposes:

- `result` (string) — Result status returned by the API.
- `data` (array) — The upgrade details. Read values via keys, e.g. `$response->data['upgrade_id']`, `$response->data['name']`, `$response->data['to_product_id']`.

## Error Handling

```php
try {
    $response = $ds24->upgrades->get($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createUpgrade](createUpgrade.md)
- [deleteUpgrade](deleteUpgrade.md)
- [listUpgrades](listUpgrades.md)
