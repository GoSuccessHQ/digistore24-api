# listAccountAccess

Lists the account access permissions granted by and to the API key owner.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listAccountAccess`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listAccountAccess.yaml)

## Parameters

- `purchaseId` (string, required) — The unique identifier of the purchase.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\AccountAccess\ListAccountAccessRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new ListAccountAccessRequest(purchaseId: 'ABCDEF12');

$response = $ds24->accountAccess->listAccesses($request);

// Accounts you have granted access to.
foreach ($response->byMe as $access) {
    echo $access->accessorId;  // e.g. 4711
    echo $access->permissions; // e.g. "can_see_revenue"
    echo $access->canSeeRevenue ? 'yes' : 'no';
}

// Accounts you have been granted access to.
foreach ($response->toMe as $access) {
    echo $access->ownerId; // e.g. 8150
}
```

## Response

`ListAccountAccessResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `byMe` (array of `AccountAccessData`) — Accounts you have granted access to.
- `toMe` (array of `AccountAccessData`) — Accounts you have been granted access to.

Each `AccountAccessData` entry exposes readable properties including `id`, `ownerId`, `accessorId`, `permissions`, `permissionsMsg`, `createdAt`, `modifiedAt`, and a set of boolean capability flags such as `canSeeNonAffiliatePurchases`, `canApproveAffiliations`, `canSeeEditMarketplaceLink`, `canEditProducts`, `canEditAffiliateCommissions`, `canReadMailHistory`, `canApprovePurchases`, `canEditPurchasesApprovalPolicy`, `canGivePermissions`, `canSeeRevenue`, `canEditDiscountVouchers`, and `canCsvExport`.

## Error Handling

```php
try {
    $response = $ds24->accountAccess->listAccesses($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [logMemberAccess](logMemberAccess.md)
