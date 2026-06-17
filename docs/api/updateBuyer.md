# updateBuyer

Updates a buyer's contact details. Every field except the buyer ID is optional; only the fields you provide are sent to the API.

## Endpoint

**PUT** `https://www.digistore24.com/api/call/updateBuyer`

[OpenAPI spec](https://digistore24.com/api/docs/paths/updateBuyer.yaml)

## Parameters

`UpdateBuyerRequest` takes the following constructor arguments:

- `buyerId` (string, required) — The buyer ID, as returned by e.g. `getPurchase`.
- `email` (string, optional) — New email address.
- `firstName` (string, optional) — New first name.
- `lastName` (string, optional) — New last name.
- `salutation` (`Salutation`, optional) — New salutation: `Salutation::MR` (`M`), `Salutation::MRS` (`F`), or `Salutation::NONE`.
- `title` (string, optional) — New title.
- `company` (string, optional) — New company name.
- `streetName` (string, optional) — New street name.
- `streetNumber` (string, optional) — New street number.
- `phoneNumber` (string, optional) — New phone number. Pass an empty string to clear it.
- `city` (string, optional) — New city.
- `zipcode` (string, optional) — New ZIP/postal code.
- `state` (string, optional) — New state/province.
- `country` (string, optional) — New two-letter ISO country code (e.g. `DE` or `AT`).

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Buyer\UpdateBuyerRequest;
use GoSuccess\Digistore24\Api\Enum\Salutation;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new UpdateBuyerRequest(
    buyerId: '12345',
    firstName: 'Jane',
    lastName: 'Doe',
    salutation: Salutation::MRS,
    city: 'Berlin',
    zipcode: '10115',
    country: 'DE',
);

$response = $ds24->buyers->update($request);

echo $response->result;     // e.g. "success"
echo $response->buyerId;    // e.g. 12345
echo $response->email;      // e.g. "jane.doe@example.com"
```

## Response

`UpdateBuyerResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `buyerId` (int|null) — The updated buyer's ID.
- `email` (string) — The buyer's email address.
- `firstName` (string|null) — The buyer's first name.
- `lastName` (string|null) — The buyer's last name.
- `company` (string|null) — The buyer's company name.
- `updatedAt` (`DateTimeInterface`|null) — When the record was updated.

## Error Handling

```php
try {
    $response = $ds24->buyers->update($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getBuyer](getBuyer.md)
- [listBuyers](listBuyers.md)
