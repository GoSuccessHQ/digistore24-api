# addBalanceToPurchase

Add or reduce balance on subscription and installment payment purchases.

## Endpoint

**POST** `https://www.digistore24.com/api/call/addBalanceToPurchase`

## OpenAPI Specification

[View OpenAPI Spec](https://digistore24.com/api/docs/paths/addBalanceToPurchase.yaml)

## Parameters

### Required Parameters

- `purchase_id` (string) - The Digistore24 order ID
- `amount` (float) - Balance to add (negative values reduce balance, but total cannot go below 0)

## Response

```json
{
  "old_balance": 100.00,
  "new_balance": 150.00
}
```

## Usage Example

```php
use Digistore24\Request\Purchase\AddBalanceToPurchaseRequest;

// Add balance
$request = new AddBalanceToPurchaseRequest(
    purchaseId: 'ABCD-1234-EFGH',
    amount: 50.00
);

$response = $digistore24->purchases->addBalance($request);
echo "Old balance: {$response->oldBalance}\n";
echo "New balance: {$response->newBalance}\n";
echo "Change: " . ($response->newBalance - $response->oldBalance);
```

## Reduce Balance

```php
// Reduce balance by using negative amount
$request = new AddBalanceToPurchaseRequest(
    purchaseId: 'ABCD-1234-EFGH',
    amount: -25.00
);

$response = $digistore24->purchases->addBalance($request);
```

## Important Notes

- **Subscription/Installment Only**: Only works for subscription and installment payment purchases
- **Billing**: Balance will be billed with the next payments
- **Negative Amounts**: Use negative values to reduce balance
- **Minimum Balance**: Total balance cannot be less than 0
- **Full Access Required**: Requires full access API key
- **Currency**: Amount must be in the currency of the order

## Related Endpoints

- [getPurchase](getPurchase.md) - Check current purchase status
- [createUpgradePurchase](createUpgradePurchase.md) - Upgrade a purchase
