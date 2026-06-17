# listEticketLocations

Lists all e-ticket event locations available in your account.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listEticketLocations`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listEticketLocations.yaml)

## Parameters

`ListEticketLocationsRequest` takes no constructor arguments.

The request is optional. Call `$ds24->etickets->listLocations()` with no argument.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$response = $ds24->etickets->listLocations();

foreach ($response->locations as $location) {
    echo $location->locationId . ': ' . $location->locationName . PHP_EOL;
    echo $location->city . ', ' . $location->country . PHP_EOL;
}
```

## Response

`ListEticketLocationsResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `locations` (array of `EticketLocation`) — The available locations.

Each `EticketLocation` exposes read-only properties:

- `locationId` (string) — The location ID (used when creating e-tickets).
- `locationName` (string) — The location name.
- `address` (string|null) — The street address, if available.
- `city` (string|null) — The city, if available.
- `country` (string|null) — The country, if available.

## Error Handling

```php
try {
    $response = $ds24->etickets->listLocations();
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createEticket](createEticket.md)
- [listEticketTemplates](listEticketTemplates.md)
- [getEticketSettings](getEticketSettings.md)
- [getEticket](getEticket.md)
- [listEtickets](listEtickets.md)
- [validateEticket](validateEticket.md)
