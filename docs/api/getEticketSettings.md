# getEticketSettings

Retrieves the e-ticket configuration settings for your account.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getEticketSettings`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getEticketSettings.yaml)

## Parameters

`GetEticketSettingsRequest` takes no constructor arguments.

The request is optional. Call `$ds24->etickets->getSettings()` with no argument.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$response = $ds24->etickets->getSettings();

if ($response->eticketEnabled) {
    echo 'Default location: ' . $response->defaultLocationId . PHP_EOL;
    echo 'Default template: ' . $response->defaultTemplateId . PHP_EOL;
    echo 'Max tickets per order: ' . $response->maxTicketsPerOrder . PHP_EOL;
}
```

## Response

`GetEticketSettingsResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `eticketEnabled` (bool) — Whether e-tickets are enabled for the account.
- `defaultLocationId` (string|null) — Default location ID, if configured.
- `defaultTemplateId` (string|null) — Default template ID, if configured.
- `maxTicketsPerOrder` (int) — Maximum number of tickets per order (defaults to `10`).
- `requireEmailValidation` (bool) — Whether email validation is required.
- `settings` (array) — Any further settings returned by the API, keyed by field name.

## Error Handling

```php
try {
    $response = $ds24->etickets->getSettings();
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
- [validateEticket](validateEticket.md)
- [listEticketLocations](listEticketLocations.md)
- [listEticketTemplates](listEticketTemplates.md)
