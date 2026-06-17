# ipnSetup

Sets up an IPN (Instant Payment Notification) connection for receiving payment notifications.

## Endpoint

**POST** `https://www.digistore24.com/api/call/ipnSetup`

[OpenAPI spec](https://digistore24.com/api/docs/paths/ipnSetup.yaml)

## Parameters

The request takes scalar and enum constructor arguments:

- `ipnUrl` (string, required) — URL where Digistore24 sends the IPN notification.
- `name` (string, required) — The name listed on Digistore24 (e.g. your platform name).
- `productIds` (string, required) — `all` or a comma-separated list of product IDs.
- `domainId` (string, optional) — Used to delete the IPN connection and ensure uniqueness. Usually your platform name.
- `categories` (array of `IpnTransactionCategory`, optional) — Transaction categories to receive notifications for. Values: `ORDERS`, `AFFILIATIONS`, `ETICKETS`, `CUSTOMFORMS`, `ORDERFORM`.
- `transactions` (array of `IpnTransactionType`, optional) — Transaction types to receive notifications for. Defaults to `PAYMENT`, `REFUND`, `CHARGEBACK`, `PAYMENT_MISSED`. Other values: `ALL`, `PAYMENT_DENIAL`, `REBILL_CANCELLED`, `REBILL_RESUMED`, `LAST_PAID_DAY`.
- `timing` (`IpnTiming`, optional) — Controls when the IPN is sent. Defaults to `IpnTiming::BEFORE_THANKYOU`. Other value: `DELAYED`.
- `shaPassphrase` (string, optional) — Password for signing parameters. Use `random` for an auto-generated 30-character password.
- `newsletterSendPolicy` (`IpnNewsletterSendPolicy`, optional) — Controls when to send the IPN based on newsletter opt-in status. Defaults to `IpnNewsletterSendPolicy::SEND_ALWAYS`. Other values: `SEND_IF_NOT_OPTOUT`, `SEND_IF_OPTOUT`, `SEND_IF_OPTIN`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Ipn\IpnSetupRequest;
use GoSuccess\Digistore24\Api\Enum\IpnTransactionCategory;
use GoSuccess\Digistore24\Api\Enum\IpnTransactionType;
use GoSuccess\Digistore24\Api\Enum\IpnTiming;
use GoSuccess\Digistore24\Api\Enum\IpnNewsletterSendPolicy;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new IpnSetupRequest(
    ipnUrl: 'https://example.com/webhooks/digistore24',
    name: 'My Platform',
    productIds: 'all',
    domainId: 'my-platform',
    categories: [
        IpnTransactionCategory::ORDERS,
        IpnTransactionCategory::AFFILIATIONS,
    ],
    transactions: [
        IpnTransactionType::PAYMENT,
        IpnTransactionType::REFUND,
        IpnTransactionType::CHARGEBACK,
    ],
    timing: IpnTiming::BEFORE_THANKYOU,
    shaPassphrase: 'random',
    newsletterSendPolicy: IpnNewsletterSendPolicy::SEND_ALWAYS,
);

$response = $ds24->ipn->setup($request);

echo $response->domainId;      // e.g. "my-platform"
echo $response->shaPassphrase; // e.g. the generated 30-character passphrase
echo $response->ipnId;         // e.g. 6789
```

## Response

`IpnSetupResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `created` (bool|null) — Whether the IPN was created.
- `updated` (bool|null) — Whether the IPN was updated.
- `deleted` (bool|null) — Whether the IPN was deleted.
- `domainId` (string|null) — Domain ID used to identify the IPN connection.
- `shaPassphrase` (string|null) — SHA passphrase for signing parameters.
- `ipnConfigId` (int|null) — IPN configuration ID.
- `ipnId` (int|null) — IPN ID.

## Error Handling

```php
try {
    $response = $ds24->ipn->setup($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [ipnInfo](ipnInfo.md)
- [ipnDelete](ipnDelete.md)
