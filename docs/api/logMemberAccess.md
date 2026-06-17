# logMemberAccess

Notifies Digistore24 that a buyer has logged into their membership account and accessed the bought content.

Important for German refund handling: only call this for purchases without the option to refund (`refund_days=0` in the IPN), and only if the buyer actually has logged in.

## Endpoint

**POST** `https://www.digistore24.com/api/call/logMemberAccess`

[OpenAPI spec](https://digistore24.com/api/docs/paths/logMemberAccess.yaml)

## Parameters

- `purchaseId` (string, required) — The ID of the purchase.
- `platformName` (string, required) — The readable name of the membership area (e.g. `VIP Club`).
- `loginName` (string, required) — The buyer's username for the membership area.
- `loginUrl` (string, required) — The URL the buyer used to log in. Must be a valid URL.
- `numberOfUnlockedLectures` (int, required) — Number of lectures the member has access to (>= 0).
- `totalNumberOfLectures` (int, required) — Total number of lectures in the course (>= 0).
- `loginAt` (\DateTimeInterface, optional) — Date and time of the login. Defaults to the current time when omitted.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\AccountAccess\LogMemberAccessRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new LogMemberAccessRequest(
    purchaseId: 'ABCDEF12',
    platformName: 'VIP Club',
    loginName: 'john.doe',
    loginUrl: 'https://members.example.com/login',
    numberOfUnlockedLectures: 3,
    totalNumberOfLectures: 12,
    loginAt: new DateTimeImmutable('2026-06-17 09:30:00'),
);

$response = $ds24->accountAccess->logAccess($request);

if ($response->success) {
    echo $response->result; // e.g. "success"
}
```

## Response

`LogMemberAccessResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `success` (bool) — Whether the access was successfully logged.
- `message` (string|null) — Optional message from the API.

## Error Handling

```php
try {
    $response = $ds24->accountAccess->logAccess($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [listAccountAccess](listAccountAccess.md)
