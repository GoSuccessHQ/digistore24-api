# listCurrencies

Retrieves all available currencies with their pricing limits.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listCurrencies`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listCurrencies.yaml)

## Parameters

- `convertTo` (string, optional) — A 3-letter currency code. When provided, price limits are converted to this target currency.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Country\ListCurrenciesRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

// The request argument is optional; $ds24->countries->listCurrencies() works as well.
$request = new ListCurrenciesRequest(convertTo: 'EUR');

$response = $ds24->countries->listCurrencies($request);

foreach ($response->currencies as $currency) {
    echo $currency->code;     // e.g. "USD"
    echo $currency->symbol;   // e.g. "$"
    echo $currency->name;     // e.g. "US Dollar"
    echo $currency->minPrice; // e.g. 1.0
    echo $currency->maxPrice; // e.g. 10000.0
}
```

## Response

`ListCurrenciesResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `currencies` (array of `CurrencyData`) — The list of currencies. Each item exposes readable properties: `id`, `code`, `symbol`, `minPrice`, `maxPrice`, and `name`.

## Error Handling

```php
try {
    $response = $ds24->countries->listCurrencies($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [listCountries](listCountries.md)
