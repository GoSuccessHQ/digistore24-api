# listSmartUpgrades

Retrieves a list of all configured smart upgrade paths.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listSmartUpgrades`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listSmartUpgrades.yaml)

## Parameters

`ListSmartUpgradesRequest` takes no parameters. The request is optional; calling `$ds24->smartUpgrades->list()` with no arguments creates it for you.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\SmartUpgrade\ListSmartUpgradesRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$response = $ds24->smartUpgrades->list(new ListSmartUpgradesRequest());

echo $response->result; // e.g. "success"

foreach ($response->smartupgrades as $upgrade) {
    // each $upgrade is an associative array of smart upgrade fields
    echo ($upgrade['name'] ?? '') . PHP_EOL;
}
```

You can also omit the request entirely:

```php
$response = $ds24->smartUpgrades->list();
```

## Response

`ListSmartUpgradesResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `smartupgrades` (array) — The smart upgrades, each represented as an associative array of fields. Read individual values with `$upgrade['key']`.

## Error Handling

```php
try {
    $response = $ds24->smartUpgrades->list(new ListSmartUpgradesRequest());
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getSmartupgrade](getSmartupgrade.md)
