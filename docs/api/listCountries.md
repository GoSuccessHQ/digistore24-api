# listCountries

Retrieves all available countries with localized names and VAT information.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listCountries`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listCountries.yaml)

## Parameters

This endpoint takes no parameters. The request can be omitted entirely, in which case the resource creates one for you.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Country\ListCountriesRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

// The request argument is optional; $ds24->countries->listCountries() works as well.
$response = $ds24->countries->listCountries(new ListCountriesRequest());

echo $response->total; // e.g. 250

foreach ($response->countries as $country) {
    echo $country->code;     // e.g. "DE"
    echo $country->name;     // e.g. "Germany"
    echo $country->euMember; // e.g. true
    echo $country->vatRate;  // e.g. 19.0
}
```

## Response

`ListCountriesResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `countries` (array of `CountryData`) — The list of countries. Each item exposes readable properties: `code`, `name`, `nameDe`, `nameEn`, `euMember`, and `vatRate`.
- `total` (int) — Total number of countries returned.

## Error Handling

```php
try {
    $response = $ds24->countries->listCountries(new ListCountriesRequest());
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [listCurrencies](listCurrencies.md)
