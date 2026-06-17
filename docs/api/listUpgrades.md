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
    echo $upgrade['name'] ?? '';
}
```

## Response

`ListUpgradesResponse` exposes:

- `result` (string) — Result status returned by the API.
- `upgrades` (array) — List of upgrade entries. Each entry is an associative array; read values via keys, e.g. `$upgrade['upgrade_id']`, `$upgrade['name']`.

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
