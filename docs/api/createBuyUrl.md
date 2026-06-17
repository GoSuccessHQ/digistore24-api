# createBuyUrl

Creates a customized order form URL with optional pre-filled buyer data, custom pricing, tracking, and more.

## Endpoint

**POST** `https://www.digistore24.com/api/call/createBuyUrl`

[OpenAPI spec](https://digistore24.com/api/docs/paths/createBuyUrl.yaml)

## Parameters

`CreateBuyUrlRequest` is built with `new CreateBuyUrlRequest()` and configured through public properties:

- `productId` (string|int, required) — The ID of the product in Digistore24. Must not be empty.
- `buyer` (`BuyerData`, optional) — Pre-filled buyer data (see below). Defaults to `null`.
- `paymentPlan` (`PaymentPlanData`, optional) — Custom price / payment plan. Defaults to `null`.
- `tracking` (`TrackingData`, optional) — Tracking data for analytics. Defaults to `null`.
- `validUntil` (string, optional) — Time period until the link expires, e.g. `24h`, `48h`, `7d`, or `forever`. Defaults to `24h`.
- `urls` (`UrlsData`, optional) — Custom thank-you, fallback, and upgrade-error URLs. Defaults to `null`.
- `placeholders` (array, optional) — Placeholders for the product title and description. Defaults to `null`.
- `settings` (`SettingsData`, optional) — Additional order form settings. Defaults to `null`.
- `addons` (array, optional) — List of add-on products. Defaults to `null`.

`BuyerData` settable properties include: `email` (string, validated), `salutation` (`Salutation`), `title`, `firstName`, `lastName`, `company`, `street`, `streetName`, `streetNumber`, `street2`, `city`, `zipcode`, `state`, `country` (auto-uppercased), `phoneNo`, `taxId`.

`PaymentPlanData` settable properties include: `firstAmount` (float >= 0), `otherAmounts` (float >= 0), `currency` (3-letter code), `numberOfInstallments` (int >= 0), `firstBillingInterval`, `otherBillingIntervals`, `testInterval`, `template`, `upgradeOrderId`, `upgradeType` (`upgrade`, `downgrade`, or `special_offer`), `taxMode` (`net` or `gross`).

`TrackingData` settable properties include: `affiliate`, `custom`, `campaignkey`, `trackingkey`, `utmSource`, `utmMedium`, `utmCampaign`, `utmTerm`, `utmContent`, plus validated `thankyou_url`, `cancellation_url`, `billing_failure_url`, `ga_tid`, and `fb_pixel_id`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\BuyUrl\CreateBuyUrlRequest;
use GoSuccess\Digistore24\Api\DTO\BuyerData;
use GoSuccess\Digistore24\Api\DTO\PaymentPlanData;
use GoSuccess\Digistore24\Api\DTO\TrackingData;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new CreateBuyUrlRequest();
$request->productId = 12345;
$request->validUntil = '48h';

// Optional: pre-fill buyer data
$buyer = new BuyerData();
$buyer->email = 'customer@example.com';
$buyer->firstName = 'John';
$buyer->lastName = 'Doe';
$buyer->country = 'DE';
$request->buyer = $buyer;

// Optional: custom single payment price
$paymentPlan = new PaymentPlanData();
$paymentPlan->firstAmount = 99.00;
$paymentPlan->currency = 'EUR';
$paymentPlan->numberOfInstallments = 1;
$request->paymentPlan = $paymentPlan;

// Optional: tracking
$tracking = new TrackingData();
$tracking->affiliate = 'partner123';
$tracking->utmSource = 'newsletter';
$request->tracking = $tracking;

$response = $ds24->buyUrls->create($request);

echo $response->id;                                   // e.g. "342033068"
echo $response->url;                                  // the order form URL
echo $response->validUntil->format('Y-m-d H:i:s');    // expiration date
echo $response->upgradeStatus;                        // "none", "ok", or "error"
```

## Response

`CreateBuyUrlResponse` exposes typed public properties:

- `id` (string|null) — ID of the created buy URL object.
- `url` (string|null) — The order form URL for the purchase.
- `validUntil` (`DateTimeImmutable`|null) — Expiration date of the URL.
- `upgradeStatus` (string|null) — Upgrade possibility status: `none`, `ok`, or `error`.

## Error Handling

```php
try {
    $response = $ds24->buyUrls->create($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [listBuyUrls](listBuyUrls.md)
- [deleteBuyUrl](deleteBuyUrl.md)
