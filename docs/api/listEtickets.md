# listEtickets

Lists e-tickets, optionally filtered by product, location, date range, or validation status.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listEtickets`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listEtickets.yaml)

## Parameters

`ListEticketsRequest` takes the following constructor arguments (all optional):

- `productId` (string, optional) — Filter by product ID.
- `locationId` (string, optional) — Filter by location ID.
- `fromDate` (\DateTimeInterface, optional) — Filter for events on or after this date (sent as `Y-m-d`).
- `toDate` (\DateTimeInterface, optional) — Filter for events on or before this date (sent as `Y-m-d`).
- `onlyValidated` (bool, optional) — `true` returns only validated tickets, `false` only unvalidated (sent as `y`/`n`).

The request is optional. Call `$ds24->etickets->list()` with no argument to list all e-tickets.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Eticket\ListEticketsRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new ListEticketsRequest(
    productId: '12345',
    fromDate: new DateTimeImmutable('2026-09-01'),
    toDate: new DateTimeImmutable('2026-09-30'),
    onlyValidated: false,
);

$response = $ds24->etickets->list($request);

echo $response->totalCount . PHP_EOL;

foreach ($response->tickets as $ticket) {
    echo $ticket->ticketId . ': ' . $ticket->productName . PHP_EOL;
    echo $ticket->buyerFirstName . ' ' . $ticket->buyerLastName . PHP_EOL;
}
```

## Response

`ListEticketsResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `tickets` (array of `EticketListItem`) — The matching e-tickets.
- `totalCount` (int) — Total number of matching tickets.

Each `EticketListItem` exposes read-only properties: `orderId` (string), `ticketId` (string), `productId` (string), `productName` (string), `locationId` (string), `locationName` (string), `eventDate` (\DateTimeInterface), `days` (int), `buyerEmail` (string), `buyerFirstName` (string), `buyerLastName` (string), `isValidated` (bool), `validatedAt` (\DateTimeInterface|null), and `createdAt` (\DateTimeInterface).

## Error Handling

```php
try {
    $response = $ds24->etickets->list($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createEticket](createEticket.md)
- [getEticket](getEticket.md)
- [validateEticket](validateEticket.md)
- [listEticketLocations](listEticketLocations.md)
- [listEticketTemplates](listEticketTemplates.md)
- [getEticketSettings](getEticketSettings.md)
