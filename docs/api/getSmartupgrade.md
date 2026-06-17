# getSmartupgrade

Retrieves detailed information about a specific smart upgrade configuration.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getSmartupgrade`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getSmartupgrade.yaml)

## Parameters

`GetSmartupgradeRequest` takes the following constructor arguments:

- `smartupgradeId` (string, required) — The unique identifier of the smart upgrade.
- `purchaseId` (string, optional) — A purchase ID used to check upgrade eligibility. Defaults to `null`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\SmartUpgrade\GetSmartupgradeRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetSmartupgradeRequest(
    smartupgradeId: '567',
    purchaseId: 'ABCD1234',
);

$response = $ds24->smartUpgrades->get($request);

echo $response->result;                 // e.g. "success"
echo $response->data['name'] ?? '';     // smart upgrade fields live in $response->data
```

## Response

`GetSmartupgradeResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `data` (array) — The smart upgrade details as an associative array. Read individual values with `$response->data['key']`.

## Error Handling

```php
try {
    $response = $ds24->smartUpgrades->get($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [listSmartUpgrades](listSmartUpgrades.md)
