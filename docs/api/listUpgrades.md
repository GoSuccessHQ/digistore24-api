# listUpgrades

Retrieves a list of all configured upgrade paths.

## Endpoint

**POST** `https://www.digistore24.com/api/call/listUpgrades`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listUpgrades.yaml)

## Parameters

This endpoint takes no parameters. The request can be omitted entirely.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$response = $ds24->upgrades->list();

foreach ($response->upgrades as $upgrade) {
    echo $upgrade->name;          // e.g. "Basic to Premium"
    echo $upgrade->toProductId;   // e.g. 124
}
```

## Response

`ListUpgradesResponse` exposes:

- `result` (string) — Result status returned by the API.
- `upgrades` (array of `UpgradeItemData`) — The configured upgrade paths. Each `UpgradeItemData` exposes: `id` (?int), `name` (?string), `upgradeUrl` (?string), `toProductId` (?int), `isActive` (?bool), `authkey` (?string), `fallbackProductId` (?int), `buyerReadonlyKeys` (?string), and `upgradeTypes` (array<string, string>).

## Error Handling

```php
try {
    $response = $ds24->upgrades->list();
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createUpgrade](createUpgrade.md)
- [getUpgrade](getUpgrade.md)
- [deleteUpgrade](deleteUpgrade.md)
