# validateEticket

Validates (scans) an e-ticket, marking it as used. Typically called at event check-in.

## Endpoint

**GET** `https://www.digistore24.com/api/call/validateEticket`

[OpenAPI spec](https://digistore24.com/api/docs/paths/validateEticket.yaml)

## Parameters

`ValidateEticketRequest` takes the following constructor argument:

- `ticketId` (string, required) — The unique ticket ID to validate.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Eticket\ValidateEticketRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new ValidateEticketRequest(ticketId: 'TICKET123');

$response = $ds24->etickets->validate($request);

if ($response->success && ! $response->wasAlreadyValidated) {
    echo 'Access granted for ' . $response->buyerName;
} elseif ($response->wasAlreadyValidated) {
    echo 'Ticket was already used.';
} else {
    echo 'Invalid ticket: ' . $response->message;
}
```

## Response

`ValidateEticketResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `success` (bool) — Whether the validation succeeded.
- `ticketId` (string) — The validated ticket ID.
- `orderId` (string) — The associated order ID.
- `productName` (string) — The event name.
- `buyerName` (string) — Full name of the buyer.
- `validatedAt` (\DateTimeInterface) — When the ticket was validated.
- `wasAlreadyValidated` (bool) — `true` if the ticket had already been validated before.
- `message` (string|null) — Optional message (e.g. a warning).

## Error Handling

```php
try {
    $response = $ds24->etickets->validate($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createEticket](createEticket.md)
- [getEticket](getEticket.md)
- [listEtickets](listEtickets.md)
- [listEticketLocations](listEticketLocations.md)
- [listEticketTemplates](listEticketTemplates.md)
- [getEticketSettings](getEticketSettings.md)
