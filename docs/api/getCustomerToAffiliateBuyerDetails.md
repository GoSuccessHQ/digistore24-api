# getCustomerToAffiliateBuyerDetails

Get customer-to-affiliate program details for specific buyer(s). Requires customer-to-affiliate program setup in Digistore24.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getCustomerToAffiliateBuyerDetails`

## OpenAPI Specification

[View OpenAPI Spec](https://digistore24.com/api/docs/paths/getCustomerToAffiliateBuyerDetails.yaml)

## Parameters

### Required Parameters

- `purchase_id` (string) - Single Digistore24 order ID or comma-separated list of order IDs

## Response

```json
{
  "ABCD-1234": {
    "data": {
      "customer_affiliate_name": "customer_john_doe",
      "customer_to_affiliate_url": "https://www.digistore24.com/affiliate/register/...",
      "customer_affiliate_promo_url": "https://www.digistore24.com/redir/123456/..."
    }
  }
}
```

### Response Fields

- `customer_affiliate_name` (string) - Username assigned to buyer if they become an affiliate
- `customer_to_affiliate_url` (string) - URL for buyer to register as an affiliate
- `customer_affiliate_promo_url` (string) - URL for the new affiliate to promote products

## Usage Example

```php
use Digistore24\Request\Purchase\GetCustomerToAffiliateBuyerDetailsRequest;

$request = new GetCustomerToAffiliateBuyerDetailsRequest(
    purchaseId: 'ABCD-1234-EFGH'
);

$response = $digistore24->purchases->getCustomerToAffiliateDetails($request);

foreach ($response->details as $purchaseId => $details) {
    echo "Purchase: {$purchaseId}\n";
    echo "Affiliate Username: {$details->customerAffiliateName}\n";
    echo "Registration URL: {$details->customerToAffiliateUrl}\n";
    echo "Promo URL: {$details->customerAffiliatePromoUrl}\n";
}
```

## Send Affiliate Invitation

```php
$request = new GetCustomerToAffiliateBuyerDetailsRequest(
    purchaseId: 'ABCD-1234'
);

$response = $digistore24->purchases->getCustomerToAffiliateDetails($request);
$details = $response->getDetailsForPurchase('ABCD-1234');

// Send email to customer with affiliate registration link
$emailBody = "
Hi,

Thank you for your purchase! We'd like to invite you to become an affiliate.

Your affiliate username will be: {$details->customerAffiliateName}
Register here: {$details->customerToAffiliateUrl}

Once registered, you can promote our products using: {$details->customerAffiliatePromoUrl}
";

mail($customerEmail, 'Become Our Affiliate!', $emailBody);
```

## Batch Processing

```php
// Get affiliate details for multiple purchases
$purchaseIds = 'ABCD-1234,WXYZ-5678,IJKL-9012';
$request = new GetCustomerToAffiliateBuyerDetailsRequest(
    purchaseId: $purchaseIds
);

$response = $digistore24->purchases->getCustomerToAffiliateDetails($request);

foreach ($response->details as $purchaseId => $details) {
    echo "Customer for {$purchaseId} can register at: {$details->customerToAffiliateUrl}\n";
}
```

## Check Affiliate Program Setup

```php
use Digistore24\Exception\ForbiddenException;
use Digistore24\Exception\NotFoundException;

try {
    $request = new GetCustomerToAffiliateBuyerDetailsRequest(
        purchaseId: 'ABCD-1234'
    );
    $response = $digistore24->purchases->getCustomerToAffiliateDetails($request);
    
    $details = $response->getDetailsForPurchase('ABCD-1234');
    echo "Affiliate program is set up correctly";
} catch (ForbiddenException $e) {
    echo "Customer-to-affiliate program not enabled or insufficient access";
} catch (NotFoundException $e) {
    echo "Purchase not found";
}
```

## Important Notes

- **Program Setup Required**: Customer-to-affiliate program must be configured in Digistore24 first
- **Full Access**: Requires full access API key
- **Username Generation**: Digistore24 automatically generates affiliate username for the customer
- **Automated Onboarding**: Perfect for automated affiliate recruitment campaigns
- **Multiple Purchases**: Supports comma-separated purchase IDs for batch operations

## Use Cases

1. **Automated Invitations**: Automatically invite customers to become affiliates after purchase
2. **Customer Engagement**: Turn satisfied customers into brand advocates
3. **Revenue Growth**: Expand affiliate network using existing customer base
4. **Personalized Onboarding**: Send customized affiliate invitation emails
5. **CRM Integration**: Integrate with your CRM for affiliate recruitment workflows

## Related Endpoints

- [getPurchase](getPurchase.md) - Get purchase details before sending invitation
- [listPurchases](listPurchases.md) - Find high-value customers to invite
- [listPurchasesOfEmail](listPurchasesOfEmail.md) - Check customer purchase history
