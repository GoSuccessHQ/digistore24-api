# getDelivery

Get details of a specific delivery.

## Endpoint

```
GET /getDelivery
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `delivery_id` | int | Yes | Delivery ID |
| `set_in_progress` | bool | No | Set delivery status to "in progress" (default: false) |

## Response Structure (PHP)

```php
GoSuccess\Digistore24\Api\Response\Delivery\GetDeliveryResponse:
  delivery: DeliveryDetailsData
    id: int
    purchaseId: string
    purchaseCreatedAt: ?DateTimeImmutable
    purchaseItemId: int
    buyerAddressId: int
    type: string
    processedAt: ?DateTimeImmutable
    processedBy: string
    productId: int
    productName: string
    productTypeId: int
    productTypeName: string
    variantLabel: string
    variantName: string
    variantKey: string
    variantId: int
    quantityDelivered: int
    quantityTotal: int
    isShippmentByResellerId: string
    isTestOrder: bool
    deliveryType: string
    invoiceUrl: string
    deliverySlipUrl: string
    deliveryAddress: DeliveryAddressData
      title: string
      salutation: string
      company: string
      firstName: string
      lastName: string
      street: string
      street2: string
      streetNumber: string
      zipcode: string
      city: string
      state: string
      country: string
      email: string
      phoneNo: string
      taxId: string
      countryName: string
    tracking: array<DeliveryTrackingData>
      deliveryId: int
      parcelServiceType: string
      serviceLabel: string
      trackingId: string
      trackingUrl: string
      quantity: int
      ipnConfigId: string
  isSetInProgress: bool
  setInProgressFailReason: ?string
```

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$api = new Digistore24($config);

// Get delivery details
$response = $api->deliveries->getDelivery(
    deliveryId: 3634
);

// Access delivery information
$delivery = $response->delivery;
echo "Product: {$delivery->productName}\n";
echo "Purchase ID: {$delivery->purchaseId}\n";
echo "Type: {$delivery->deliveryType}\n";

// Access delivery address
$address = $delivery->deliveryAddress;
echo "Ship to: {$address->firstName} {$address->lastName}\n";
echo "City: {$address->city}, {$address->countryName}\n";

// Access tracking information
foreach ($delivery->tracking as $track) {
    echo "Service: {$track->serviceLabel}\n";
    echo "Tracking ID: {$track->trackingId}\n";
    echo "URL: {$track->trackingUrl}\n";
}

// Optionally set delivery status to "in progress"
$response = $api->deliveries->getDelivery(
    deliveryId: 3634,
    setInProgress: true
);

if ($response->isSetInProgress) {
    echo "Delivery status updated to in progress\n";
} else {
    echo "Failed: {$response->setInProgressFailReason}\n";
}
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 404 | Delivery not found | Delivery ID does not exist |
| 403 | Access denied | Not authorized to access this delivery |

## Notes

- Returns comprehensive delivery information including address, tracking, and product details
- The `set_in_progress` parameter automatically updates the delivery status
- Multiple tracking entries are supported (array of tracking data)
- Test orders are indicated by the `isTestOrder` flag
- Timestamps are returned as DateTimeImmutable objects
