# getUserInfo

Retrieves information about the authenticated user/vendor account.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getUserInfo`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getUserInfo.yaml)

## Parameters

This endpoint takes no parameters. The request can be omitted entirely, in which case the resource creates one for you.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\User\GetUserInfoRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

// The request argument is optional; $ds24->users->getInfo() works as well.
$response = $ds24->users->getInfo(new GetUserInfoRequest());

echo $response->result; // e.g. "success"

// The account details are returned as an associative array.
$email = $response->userInfo['email'] ?? null;
$name = $response->userInfo['name'] ?? null;
```

## Response

`GetUserInfoResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `userInfo` (array) — The user account details as an associative array; read individual fields via `$response->userInfo['key']`.

## Error Handling

```php
try {
    $response = $ds24->users->getInfo(new GetUserInfoRequest());
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getPurchaseTracking](getPurchaseTracking.md)
