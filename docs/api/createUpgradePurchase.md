# createUpgradePurchase

Create an upgrade purchase without user interaction. Requires full access and "Billing on demand" permission.

## Endpoint

**POST** `https://www.digistore24.com/api/call/createUpgradePurchase`

## OpenAPI Specification

[View OpenAPI Spec](https://digistore24.com/api/docs/paths/createUpgradePurchase.yaml)

## Parameters

### Required Parameters

- `purchase_ids` (string) - Comma-separated list of purchase IDs
- `upgrade_id` (string) - ID of the upgrade (numeric NNN or with authkey NNN-XXXXXXX)

### Optional Parameters

- `payment_plan_id` (string) - ID or index (starting with 1) of the payment plan
- `quantities` (object) - Quantities for main product and addons (key = item position or product ID)

## Response

```json
{
  "data": {
    "new_purchase": {
      "id": "UPGRADE-5678",
      "billing_status": "active",
      "paid_amount": 50.00,
      "next_payment_at": "2024-04-15",
      "next_amount": 49.00,
      "currency": "EUR"
    },
    "upgrade_info": {
      "upgrade_type": "standard",
      "upgrade_amount_left": 100.00,
      "upgrade_amount_total": 150.00,
      "upgraded_purchase_id": "ABCD-1234"
    }
  }
}
```

## Usage Example

```php
use Digistore24\Request\Purchase\CreateUpgradePurchaseRequest;

$request = new CreateUpgradePurchaseRequest(
    purchaseIds: 'ABCD-1234',
    upgradeId: '456',
    paymentPlanId: '1',
    quantities: ['1' => 1, '2' => 3]
);

$response = $digistore24->purchases->createUpgrade($request);
echo "New purchase ID: {$response->newPurchase->id}";
echo "Upgrade amount remaining: {$response->upgradeInfo->upgradeAmountLeft}";
```

## Important Notes

- **User Consent**: You MUST ensure the buyer is informed and agrees to automatic upgrades
- **Full Access Required**: Requires full access API key
- **Billing on Demand**: "Billing on demand" permission must be enabled
- **Payment Plans**: Use payment plan ID or index starting with 1

## Related Endpoints

- [getPurchase](getPurchase.md) - Get purchase details before upgrading
- [addBalanceToPurchase](addBalanceToPurchase.md) - Add balance after upgrade
