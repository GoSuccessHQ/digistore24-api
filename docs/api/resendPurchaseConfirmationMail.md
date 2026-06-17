# resendPurchaseConfirmationMail

Resends the order confirmation email to the buyer.

## Endpoint

**POST** `https://www.digistore24.com/api/call/resendPurchaseConfirmationMail`

[OpenAPI spec](https://digistore24.com/api/docs/paths/resendPurchaseConfirmationMail.yaml)

## Parameters

Constructor arguments of `ResendPurchaseConfirmationMailRequest`:

- `purchaseId` (string, required) — The Digistore24 order ID.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Purchase\ResendPurchaseConfirmationMailRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new ResendPurchaseConfirmationMailRequest(purchaseId: '12345678');

$response = $ds24->purchases->resendConfirmationMail($request);

if ($response->wasSuccessful()) {
    echo 'Confirmation email sent.';

    if ($response->note !== null) {
        echo $response->note;
    }
}
```

## Response

`ResendPurchaseConfirmationMailResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `modified` (string) — `Y` if the email was sent, `N` otherwise.
- `note` (string|null) — Optional note about the operation.

Helper method:

- `wasSuccessful(): bool` — Returns `true` when `modified` equals `Y`.

## Error Handling

```php
try {
    $response = $ds24->purchases->resendConfirmationMail($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getPurchase](getPurchase.md)
- [listPurchasesOfEmail](listPurchasesOfEmail.md)
- [updatePurchase](updatePurchase.md)
