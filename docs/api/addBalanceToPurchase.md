# addBalanceToPurchase

Adds balance to a subscription or installment order, which is billed with the next payments.

## Endpoint

**POST** `https://www.digistore24.com/api/call/addBalanceToPurchase`

[OpenAPI spec](https://digistore24.com/api/docs/paths/addBalanceToPurchase.yaml)

## Parameters

Constructor arguments of `AddBalanceToPurchaseRequest`:

- `purchaseId` (string, required) — The Digistore24 order ID.
- `amount` (float, required) — The balance to add. Negative values reduce the balance, but the total cannot go below 0.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Purchase\AddBalanceToPurchaseRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new AddBalanceToPurchaseRequest(
    purchaseId: '12345678',
    amount: 25.0,
);

$response = $ds24->purchases->addBalance($request);

echo $response->oldBalance;          // e.g. 0.0
echo $response->newBalance;          // e.g. 25.0
echo $response->getBalanceChange();  // e.g. 25.0
```

To reduce the balance, pass a negative amount:

```php
$request = new AddBalanceToPurchaseRequest(
    purchaseId: '12345678',
    amount: -10.0,
);
```

## Response

`AddBalanceToPurchaseResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `oldBalance` (float) — Balance before the change.
- `newBalance` (float) — Balance after the change.

It also provides a helper method:

- `getBalanceChange(): float` — Returns `newBalance - oldBalance`.

## Error Handling

```php
try {
    $response = $ds24->purchases->addBalance($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getPurchase](getPurchase.md)
- [updatePurchase](updatePurchase.md)
- [createBillingOnDemand](createBillingOnDemand.md)
- [refundPartially](refundPartially.md)
