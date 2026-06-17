# reportFraud

Reports the customer and/or the affiliate of a transaction as fraud.

## Endpoint

**POST** `https://www.digistore24.com/api/call/reportFraud`

[OpenAPI spec](https://digistore24.com/api/docs/paths/reportFraud.yaml)

## Parameters

- `transactionId` (int, required) — The numeric ID of the fraud transaction.
- `who` (string, required) — Who is being reported: `buyer`, `affiliate`, or `buyer,affiliate`.
- `comment` (string, required) — Explanation of why this is considered a fraud order.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Fraud\ReportFraudRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new ReportFraudRequest(
    transactionId: 987654,
    who: 'buyer',
    comment: 'Chargeback after delivery; buyer unreachable.',
);

$response = $ds24->fraud->report($request);

echo $response->buyerStatus;  // e.g. "success"
echo $response->buyerMessage; // human-readable message
echo $response->buyerCode;    // e.g. "created_entry"
```

## Response

`ReportFraudResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `buyerStatus` (string) — Status of the buyer report (`info`, `success`, `warning`, or `failure`).
- `buyerMessage` (string) — Message about the buyer report.
- `buyerCode` (string) — Code for the buyer report (`created_entry`, `rerequest`, or `not_created`).
- `affiliateStatus` (string) — Status of the affiliate report (`info`, `success`, `warning`, or `failure`).
- `affiliateMessage` (string) — Message about the affiliate report.
- `affiliateCode` (string) — Code for the affiliate report (`created_entry`, `rerequest`, or `not_created`).

## Error Handling

```php
try {
    $response = $ds24->fraud->report($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [validateLicenseKey](validateLicenseKey.md)
