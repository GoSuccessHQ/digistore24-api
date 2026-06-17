# getGlobalSettings

Returns global Digistore24 system settings such as product types, countries, currencies, languages, payment methods, and VAT rates.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getGlobalSettings`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getGlobalSettings.yaml)

## Parameters

`GetGlobalSettingsRequest` takes no parameters. The request is optional; calling `$ds24->system->getGlobalSettings()` with no arguments creates it for you.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\System\GetGlobalSettingsRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$response = $ds24->system->getGlobalSettings(new GetGlobalSettingsRequest());

foreach ($response->productTypes as $type) {
    echo $type['id'] . ': ' . $type['name'] . PHP_EOL;
}

foreach ($response->currencies as $currency) {
    echo $currency['code'] . ' (' . $currency['symbol'] . ')' . PHP_EOL;
}

$germanVat = $response->vatRates['DE'] ?? 0.0;
echo 'VAT rate for Germany: ' . $germanVat . '%' . PHP_EOL;
```

You can also omit the request entirely:

```php
$response = $ds24->system->getGlobalSettings();
```

## Response

`GetGlobalSettingsResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `productTypes` (array) — List of `['id' => int, 'name' => string]` entries.
- `countries` (array) — List of `['code' => string, 'name' => string]` entries.
- `currencies` (array) — List of `['code' => string, 'symbol' => string, 'name' => string]` entries.
- `languages` (array) — List of `['code' => string, 'name' => string]` entries.
- `paymentMethods` (string[]) — Available payment method identifiers.
- `vatRates` (array) — VAT rates keyed by country code, e.g. `['DE' => 19.0]`.

## Error Handling

```php
try {
    $response = $ds24->system->getGlobalSettings(new GetGlobalSettingsRequest());
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [ping](ping.md)
