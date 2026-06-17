# deleteUpgrade

Deletes an existing upgrade path by its unique identifier.

## Endpoint

**DELETE** `https://www.digistore24.com/api/call/deleteUpgrade`

[OpenAPI spec](https://digistore24.com/api/docs/paths/deleteUpgrade.yaml)

## Parameters

- `upgradeId` (string, required) — The unique identifier of the upgrade to delete.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Upgrade\DeleteUpgradeRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new DeleteUpgradeRequest(upgradeId: '789');

$response = $ds24->upgrades->delete($request);

echo $response->wasSuccessful() ? 'deleted' : 'failed';
```

## Response

`DeleteUpgradeResponse` exposes:

- `result` (string) — Result status returned by the API.
- `wasSuccessful(): bool` — `true` when `result` equals `success`.

## Error Handling

```php
try {
    $response = $ds24->upgrades->delete($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createUpgrade](createUpgrade.md)
- [getUpgrade](getUpgrade.md)
- [listUpgrades](listUpgrades.md)
