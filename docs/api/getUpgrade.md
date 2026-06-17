# getUpgrade

Retrieves detailed information about a specific upgrade path.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getUpgrade`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getUpgrade.yaml)

## Parameters

- `upgradeId` (string, required) — The numeric ID of the upgrade to retrieve.
- `orderIds` (string, optional) — Comma-separated list of order IDs to check upgrade possibility for. When set, the response includes a populated `check` object. Defaults to `null`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Upgrade\GetUpgradeRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetUpgradeRequest(upgradeId: '789', orderIds: 'ABC123,DEF456');

$response = $ds24->upgrades->get($request);

echo $response->result;                   // e.g. "success"
echo $response->item?->name;              // e.g. "Basic to Premium"
echo $response->item?->toProductId;       // e.g. 124
echo $response->check?->isUpgradePossible ? 'yes' : 'no';
```

## Response

`GetUpgradeResponse` exposes:

- `result` (string) — Result status returned by the API.
- `item` (`?UpgradeItemData`) — The upgrade details (spec key `item`), or `null`. Relevant properties:
  - `id` (?int), `name` (?string), `upgradeUrl` (?string), `toProductId` (?int), `toProductName` (?string), `isActive` (?bool), `authkey` (?string), `fallbackProductId` (?int), `buyerReadonlyKeys` (?string), `upgradeTypes` (array<string, string> mapping source product ID to `upgrade`/`downgrade`/`special_offer`).
- `check` (`?UpgradeCheckData`) — Upgrade-possibility result for the supplied `orderIds`, or `null` when none were passed. Properties:
  - `isUpgradePossible` (?bool), `isOneClickPaymentPossible` (?bool), `possibleUpgradeType` (?string — `upgrade` or `downgrade`).
- `data` (array) — The complete inner payload, accessible by key.

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
