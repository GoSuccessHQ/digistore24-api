# getBuyer

Retrieves a single buyer's contact details by buyer ID or email address.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getBuyer`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getBuyer.yaml)

## Parameters

`GetBuyerRequest` takes the following constructor argument:

- `buyerId` (string, required) — The buyer ID or the buyer's email address.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Buyer\GetBuyerRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetBuyerRequest(buyerId: 'customer@example.com');

$response = $ds24->buyers->get($request);

echo $response->result;             // e.g. "success"
echo $response->buyer->id;          // e.g. 12345
echo $response->buyer->email;       // e.g. "customer@example.com"
echo $response->buyer->firstName;   // e.g. "John"
echo $response->buyer->lastName;    // e.g. "Doe"
echo $response->buyer->country;     // e.g. "DE"
```

## Response

`GetBuyerResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `buyer` (`BuyerData`|null) — The buyer record. Notable read-only properties include `id` (int), `addressId` (int), `email` (string), `salutation` (`Salutation`), `title`, `firstName`, `lastName`, `company`, `street`, `streetName`, `streetNumber`, `street2`, `city`, `zipcode`, `state`, `country`, `phoneNo`, `taxId`, `buyerType` (`BuyerType`), and `createdAt` (`DateTimeImmutable`).

## Error Handling

```php
try {
    $response = $ds24->buyers->get($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [listBuyers](listBuyers.md)
- [updateBuyer](updateBuyer.md)
