# createUpgrade

Creates a new upgrade path between products.

## Endpoint

**POST** `https://www.digistore24.com/api/call/createUpgrade`

[OpenAPI spec](https://digistore24.com/api/docs/paths/createUpgrade.yaml)

## Parameters

The request wraps an `UpgradeData` DTO. Populate the following settable properties before passing it to the request:

- `name` (string, required) — Name of the new upgrade. Must not exceed 255 characters.
- `toProductId` (int, required) — The product ID being sold as the upgrade. Must be positive.
- `upgradeFrom` (string, optional) — Comma-separated list of product IDs that can be upgraded from. Changes take effect immediately. Defaults to `''`.
- `downgradeFrom` (string, optional) — Comma-separated list of product IDs that can be downgraded from. Changes take effect next billing period. Defaults to `''`.
- `specialOfferFor` (string, optional) — Comma-separated list of product IDs eligible for special member offers. Defaults to `''`.
- `fallbackProductId` (int, optional) — Product ID to offer if the upgrade is not possible. Must be positive when set. Defaults to `null`.
- `isActive` (bool, optional) — Whether the upgrade is active and purchasable. Defaults to `true`.
- `buyerReadonlyKeys` (string, optional) — Which buyer data fields are protected: `none`, `email`, `email_and_name`, or `all`. Defaults to `none`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Upgrade\CreateUpgradeRequest;
use GoSuccess\Digistore24\Api\DTO\UpgradeData;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$upgrade = new UpgradeData();
$upgrade->name = 'Basic to Premium';
$upgrade->toProductId = 124;
$upgrade->upgradeFrom = '123';
$upgrade->isActive = true;

$request = new CreateUpgradeRequest(upgrade: $upgrade);

$response = $ds24->upgrades->create($request);

echo $response->getUpgradeId();                       // e.g. 789 (int)
echo $response->wasSuccessful() ? 'created' : 'failed';
```

## Response

`CreateUpgradeResponse` exposes:

- `result` (string) — Result status returned by the API.
- `upgradeId` (?int) — ID of the newly created upgrade.
- `data` (array) — Inner response payload. Read values such as `$response->data['upgrade_id']`.
- `getUpgradeId(): ?int` — Convenience accessor for the new upgrade ID.
- `wasSuccessful(): bool` — `true` when `result` equals `success`.

## Error Handling

```php
try {
    $response = $ds24->upgrades->create($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getUpgrade](getUpgrade.md)
- [deleteUpgrade](deleteUpgrade.md)
- [listUpgrades](listUpgrades.md)
