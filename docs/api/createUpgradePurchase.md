# createUpgradePurchase

Performs an upgrade for one or more orders without user interaction. Requires full access rights and the "Billing on demand" permission.

## Endpoint

**POST** `https://www.digistore24.com/api/call/createUpgradePurchase`

[OpenAPI spec](https://digistore24.com/api/docs/paths/createUpgradePurchase.yaml)

You must ensure the buyer is informed and agrees to automatic upgrades.

## Parameters

Constructor arguments of `CreateUpgradePurchaseRequest`:

- `purchaseIds` (string, required) — Comma-separated list of purchase IDs to upgrade.
- `upgradeId` (string, required) — ID of the upgrade to apply (numeric `NNN` or with authkey `NNN-XXXXXXX`).
- `paymentPlanId` (string, optional) — ID or index (starting at 1) of the payment plan.
- `quantities` (array, optional) — Quantities for the main product and add-ons, keyed by item position or product ID.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Purchase\CreateUpgradePurchaseRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new CreateUpgradePurchaseRequest(
    purchaseIds: '12345678',
    upgradeId: '456',
    paymentPlanId: '1',
    quantities: ['1' => 1, '2' => 3],
);

$response = $ds24->purchases->createUpgrade($request);

$newPurchase = $response->getNewPurchase();
$upgradeInfo = $response->getUpgradeInfo();

echo $newPurchase['id'] ?? '';                  // ID of the new order
echo $upgradeInfo['upgrade_amount_left'] ?? ''; // remaining upgrade amount
```

## Response

`CreateUpgradePurchaseResponse` exposes:

- `result` (string) — Result status returned by the API.
- `data` (array) — The full response payload. Read individual values via the helper methods below.

Helper methods:

- `getNewPurchase(): ?array` — Details of the newly created order (`$response->data['new_purchase']`), or `null` if absent.
- `getUpgradeInfo(): ?array` — Upgrade details (`$response->data['upgrade_info']`), or `null` if absent.

## Error Handling

```php
try {
    $response = $ds24->purchases->createUpgrade($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createAddonChangePurchase](createAddonChangePurchase.md)
- [createBillingOnDemand](createBillingOnDemand.md)
- [addBalanceToPurchase](addBalanceToPurchase.md)
- [getPurchase](getPurchase.md)
