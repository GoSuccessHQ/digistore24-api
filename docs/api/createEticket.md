# createEticket

Creates one or more free e-tickets for an event.

## Endpoint

**POST** `https://www.digistore24.com/api/call/createEticket`

[OpenAPI spec](https://digistore24.com/api/docs/paths/createEticket.yaml)

## Parameters

`CreateEticketRequest` takes the following constructor arguments:

- `buyer` (BuyerData, required) — Buyer information. Only `email` is required; `title`, `salutation`, `firstName`, and `lastName` are optional and included when set.
- `productId` (string, required) — The product ID.
- `locationId` (string, required) — The location ID (see [listEticketLocations](listEticketLocations.md)).
- `templateId` (string, required) — The template ID (see [listEticketTemplates](listEticketTemplates.md)).
- `date` (\DateTimeInterface, required) — Event date (sent as `Y-m-d`).
- `days` (int, optional) — Number of days the event lasts. Defaults to `1`; must be at least `1`.
- `note` (string, optional) — Optional note (e.g. the event time).
- `count` (int, optional) — Number of e-tickets to create. Defaults to `1`; must be at least `1`.

The `buyer` argument is a `BuyerData` DTO. Populate at least its `email` property:

- `email` (string, required) — Buyer email address. Validated as an email.
- `title` (string, optional) — Title (e.g. `Dr.`).
- `salutation` (Salutation, optional) — `Salutation::MR` or `Salutation::MRS` (sent lowercase as `m`/`f`).
- `firstName` (string, optional) — Buyer first name.
- `lastName` (string, optional) — Buyer last name.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Eticket\CreateEticketRequest;
use GoSuccess\Digistore24\Api\DTO\BuyerData;
use GoSuccess\Digistore24\Api\Enum\Salutation;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$buyer = new BuyerData(
    email: 'attendee@example.com',
    salutation: Salutation::MR,
    firstName: 'John',
    lastName: 'Doe',
);

$request = new CreateEticketRequest(
    buyer: $buyer,
    productId: '12345',
    locationId: '5432',
    templateId: '1234',
    date: new DateTimeImmutable('2026-09-15'),
    days: 1,
    note: 'Doors open at 18:00',
    count: 2,
);

$response = $ds24->etickets->create($request);

foreach ($response->etickets as $eticket) {
    echo $eticket->id . ': ' . $eticket->url . PHP_EOL;
}
```

## Response

`CreateEticketResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `etickets` (array of `EticketItem`) — The created e-tickets.

Each `EticketItem` exposes:

- `id` (string) — The e-ticket ID.
- `url` (string) — Download URL for the e-ticket PDF.
- `email` (string) — Email address the e-ticket was created for.

## Error Handling

```php
try {
    $response = $ds24->etickets->create($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getEticket](getEticket.md)
- [listEtickets](listEtickets.md)
- [validateEticket](validateEticket.md)
- [listEticketLocations](listEticketLocations.md)
- [listEticketTemplates](listEticketTemplates.md)
- [getEticketSettings](getEticketSettings.md)
