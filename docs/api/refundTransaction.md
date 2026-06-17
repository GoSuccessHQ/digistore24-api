# refundTransaction

Processes a full refund for a specific transaction.

## Endpoint

**POST** `https://www.digistore24.com/api/call/refundTransaction`

[OpenAPI spec](https://digistore24.com/api/docs/paths/refundTransaction.yaml)

## Parameters

`RefundTransactionRequest` takes the following constructor arguments:

- `transactionId` (string, required) — The unique identifier of the transaction to refund.
- `force` (bool, optional) — Force the refund even if it is outside the refund period. Defaults to `null`.
- `requestDate` (string, optional) — Custom request date in `YYYY-MM-DD` format. Defaults to `null`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Transaction\RefundTransactionRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new RefundTransactionRequest(
    transactionId: 'TX-12345',
    force: true,
);

$response = $ds24->transactions->refund($request);

echo $response->result;                       // e.g. "success"
echo $response->status;                       // refund status
echo $response->modified === 'Y' ? 'refunded' : 'unchanged';
```

## Response

`RefundTransactionResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `status` (string) — The refund status.
- `modified` (string) — Whether the transaction was modified: `Y` or `N`.

## Error Handling

```php
try {
    $response = $ds24->transactions->refund($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [listTransactions](listTransactions.md)
