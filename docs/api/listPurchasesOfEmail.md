# listPurchasesOfEmail

Retrieves all purchases belonging to a specific email address.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listPurchasesOfEmail`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listPurchasesOfEmail.yaml)

## Parameters

Constructor arguments of `ListPurchasesOfEmailRequest`:

- `email` (string, required) — The buyer's email address.
- `limit` (int, optional) — Maximum number of purchases to show. Minimum 1. Defaults to `100`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Purchase\ListPurchasesOfEmailRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new ListPurchasesOfEmailRequest(
    email: 'customer@example.com',
    limit: 50,
);

$response = $ds24->purchases->listByEmail($request);

foreach ($response->purchases as $purchase) {
    echo $purchase['id'] ?? '';
    echo $purchase['amount'] ?? '';
    echo $purchase['currency'] ?? '';
}

echo count($response->purchases);
```

## Response

`ListPurchasesOfEmailResponse` exposes:

- `result` (string) — Result status returned by the API.
- `purchases` (array) — A list of purchases for the email address. Each entry is an associative array; read values via `$purchase['id']`, `$purchase['amount']`, etc.

## Error Handling

```php
try {
    $response = $ds24->purchases->listByEmail($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [listPurchases](listPurchases.md)
- [getPurchase](getPurchase.md)
- [getCustomerToAffiliateBuyerDetails](getCustomerToAffiliateBuyerDetails.md)
