# resendPurchaseConfirmationMail

Resend the order confirmation email to the buyer.

## Endpoint

**POST** `https://www.digistore24.com/api/call/resendPurchaseConfirmationMail`

## OpenAPI Specification

[View OpenAPI Spec](https://digistore24.com/api/docs/paths/resendPurchaseConfirmationMail.yaml)

## Parameters

### Required Parameters

- `purchase_id` (string) - The Digistore24 order ID

## Response

```json
{
  "data": {
    "modified": "Y",
    "note": "Email sent successfully"
  }
}
```

## Usage Example

```php
use Digistore24\Request\Purchase\ResendPurchaseConfirmationMailRequest;

$request = new ResendPurchaseConfirmationMailRequest(
    purchaseId: 'ABCD-1234-EFGH'
);

$response = $digistore24->purchases->resendConfirmationMail($request);

if ($response->wasSuccessful()) {
    echo "Confirmation email sent";
    if ($response->note) {
        echo "Note: {$response->note}";
    }
} else {
    echo "Failed to send email";
}
```

## Customer Support

```php
// Customer says they didn't receive confirmation email
$request = new ResendPurchaseConfirmationMailRequest(
    purchaseId: 'CUSTOMER-PURCHASE-ID'
);

try {
    $response = $digistore24->purchases->resendConfirmationMail($request);
    echo "Email resent to customer";
} catch (\Digistore24\Exception\ApiException $e) {
    echo "Error: " . $e->getMessage();
}
```

## Important Notes

- **Duplicate Emails**: Customer will receive another copy of the original confirmation
- **Email Limits**: Be mindful of spam filters when resending multiple times
- **Customer Support**: Useful for customers who lost or deleted their confirmation

## Related Endpoints

- [getPurchase](getPurchase.md) - Verify purchase details before resending
- [listPurchasesOfEmail](listPurchasesOfEmail.md) - Find purchase by customer email
