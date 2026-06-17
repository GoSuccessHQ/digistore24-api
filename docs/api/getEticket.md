# getEticket

Retrieves detailed information about a single e-ticket by its order ID.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getEticket`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getEticket.yaml)

## Parameters

`GetEticketRequest` takes the following constructor argument:

- `orderId` (string, required) — The order ID of the e-ticket to retrieve.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Eticket\GetEticketRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetEticketRequest(orderId: 'ORDER123');

$response = $ds24->etickets->get($request);

$ticket = $response->ticket;

echo $ticket->productName . PHP_EOL;
echo $ticket->locationName . PHP_EOL;
echo $ticket->eventDate->format('Y-m-d') . PHP_EOL;
echo $ticket->isValidated ? 'Validated' : 'Not validated';
```

## Response

`GetEticketResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `ticket` (`EticketDetail`) — The e-ticket details.

The `EticketDetail` object exposes read-only properties:

- `orderId` (string) — The order ID.
- `ticketId` (string) — The unique ticket ID.
- `productId` (string) — The product ID for the event.
- `productName` (string) — The event name.
- `locationId` (string) — The location ID.
- `locationName` (string) — The readable location name.
- `templateId` (string) — The template ID.
- `eventDate` (\DateTimeInterface) — Date of the event.
- `days` (int) — Number of days the event lasts.
- `note` (string|null) — Optional note (e.g. time, gate info).
- `buyerEmail` (string) — Email address of the buyer.
- `buyerFirstName` (string) — Buyer first name.
- `buyerLastName` (string) — Buyer last name.
- `isValidated` (bool) — Whether the ticket has been validated/used.
- `validatedAt` (\DateTimeInterface|null) — When the ticket was validated, if at all.
- `createdAt` (\DateTimeInterface) — When the ticket was created.

## Error Handling

```php
try {
    $response = $ds24->etickets->get($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createEticket](createEticket.md)
- [listEtickets](listEtickets.md)
- [validateEticket](validateEticket.md)
- [listEticketLocations](listEticketLocations.md)
- [listEticketTemplates](listEticketTemplates.md)
- [getEticketSettings](getEticketSettings.md)
