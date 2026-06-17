# ping

Tests the connection to the Digistore24 server and returns the server time. Useful for connectivity checks and time synchronization.

## Endpoint

**GET** `https://www.digistore24.com/api/call/ping`

[OpenAPI spec](https://digistore24.com/api/docs/paths/ping.yaml)

## Parameters

`PingRequest` takes no parameters. The request is optional; calling `$ds24->system->ping()` with no arguments creates it for you.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\System\PingRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$response = $ds24->system->ping(new PingRequest());

if ($response->wasSuccessful()) {
    echo 'Connected. API version: ' . $response->apiVersion . PHP_EOL;
    echo 'Server time: ' . $response->serverTime?->format('Y-m-d H:i:s') . PHP_EOL;
    echo 'Runtime: ' . $response->runtimeSeconds . 's' . PHP_EOL;
}
```

You can also omit the request entirely:

```php
$response = $ds24->system->ping();
```

## Response

`PingResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `apiVersion` (string) — The API version.
- `currentTime` (`DateTimeImmutable`|null) — Current server time (top-level field).
- `serverTime` (`DateTimeImmutable`|null) — Server time from the data field.
- `runtimeSeconds` (float) — Request runtime in seconds.

It also provides a helper method:

- `wasSuccessful()` (bool) — Returns `true` when the result is `success` or `ok`.

## Error Handling

```php
try {
    $response = $ds24->system->ping(new PingRequest());
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getGlobalSettings](getGlobalSettings.md)
