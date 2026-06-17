# renderJsTrackingCode

Creates a JavaScript snippet that reads the current affiliate, campaign key, and tracking key on a landing page and stores them, for example in hidden form inputs.

## Endpoint

**GET** `https://www.digistore24.com/api/call/renderJsTrackingCode`

[OpenAPI spec](https://digistore24.com/api/docs/paths/renderJsTrackingCode.yaml)

## Parameters

- `affiliateInput` (string, optional) — The name of the HTML form input field that should receive the affiliate name.
- `campaignkeyInput` (string, optional) — The name of the HTML form input field that should receive the campaign key.
- `trackingkeyInput` (string, optional) — The name of the HTML form input field that should receive the tracking key.
- `callback` (string, optional) — The name of a JavaScript function to be called with the data.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Tracking\RenderJsTrackingCodeRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

// The request argument is optional; $ds24->tracking->renderJsCode() works as well.
$request = new RenderJsTrackingCodeRequest(
    affiliateInput: 'aff',
    campaignkeyInput: 'campaignkey',
    trackingkeyInput: 'trackingkey',
);

$response = $ds24->tracking->renderJsCode($request);

echo $response->scriptCode; // the full <script> tag to embed
echo $response->scriptUrl;  // the script URL
```

## Response

`RenderJsTrackingCodeResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `scriptCode` (string) — The complete JavaScript tag to be embedded on the landing page.
- `scriptUrl` (string) — The script URL.

## Error Handling

```php
try {
    $response = $ds24->tracking->renderJsCode($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getPurchaseTracking](getPurchaseTracking.md)
