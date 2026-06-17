# listEticketTemplates

Lists all e-ticket templates available in your account.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listEticketTemplates`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listEticketTemplates.yaml)

## Parameters

`ListEticketTemplatesRequest` takes no constructor arguments.

The request is optional. Call `$ds24->etickets->listTemplates()` with no argument.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$response = $ds24->etickets->listTemplates();

foreach ($response->templates as $template) {
    echo $template->templateId . ': ' . $template->templateName . PHP_EOL;
    if ($template->previewUrl !== null) {
        echo 'Preview: ' . $template->previewUrl . PHP_EOL;
    }
}
```

## Response

`ListEticketTemplatesResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `templates` (array of `EticketTemplate`) — The available templates.

Each `EticketTemplate` exposes read-only properties:

- `templateId` (string) — The template ID (used when creating e-tickets).
- `templateName` (string) — The template name.
- `description` (string|null) — The template description, if available.
- `previewUrl` (string|null) — A preview URL, if available.

## Error Handling

```php
try {
    $response = $ds24->etickets->listTemplates();
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createEticket](createEticket.md)
- [listEticketLocations](listEticketLocations.md)
- [getEticketSettings](getEticketSettings.md)
- [getEticket](getEticket.md)
- [listEtickets](listEtickets.md)
- [validateEticket](validateEticket.md)
