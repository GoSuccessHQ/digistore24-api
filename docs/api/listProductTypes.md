# listProductTypes

List all available product types in Digistore24.

## Description

Returns a comprehensive list of all product types available in Digistore24. This endpoint is essential when creating or updating products, as you need to specify a valid `product_type_id`. Each product type has a unique ID, name, and belongs to a specific category.

Use this endpoint to:
- Discover available product types before creating products
- Validate product type IDs
- Filter product types by category
- Display product type options in user interfaces

## OpenAPI Specification

[View OpenAPI Specification](https://digistore24.com/api/docs/paths/listProductTypes.yaml)

## Request

### Parameters

This endpoint does not require any parameters.

### Example Request

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

// No request object needed - all parameters are optional
$response = $client->products->listProductTypes();
```

## Response

### Response Object

The response contains an array of product type objects, each with:

- `id` (integer): Unique product type ID
- `name` (string): Human-readable product type name
- `category` (string): Product type category

### Response Methods

```php
// Get all product types
$allTypes = $response->productTypes;

// Get a specific product type by ID
$productType = $response->getProductTypeById(1);
if ($productType !== null) {
    echo "Type: {$productType->name} (Category: {$productType->category})";
}

// Get product types in a specific category
$digitalTypes = $response->getProductTypesByCategory('Digital');

// Get all unique categories
$categories = array_values(array_unique(array_map(fn ($type) => $type->category, $response->productTypes)));
```

### Example Response

```json
[
  {
    "id": 1,
    "name": "Standard Product",
    "category": "Digital"
  },
  {
    "id": 2,
    "name": "Subscription",
    "category": "Digital"
  },
  {
    "id": 3,
    "name": "Physical Product",
    "category": "Physical"
  },
  {
    "id": 4,
    "name": "Service",
    "category": "Service"
  },
  {
    "id": 5,
    "name": "Ticket/Event",
    "category": "Event"
  }
]
```

## Use Cases

### 1. Display Product Type Selector

Show available product types when creating a new product:

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Product\ListProductTypesRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

$request = new ListProductTypesRequest();
$response = $client->products->listProductTypes($request);

// Group by category for better UI organization
$categories = array_values(array_unique(array_map(fn ($type) => $type->category, $response->productTypes)));

echo "<h2>Select Product Type</h2>";
foreach ($categories as $category) {
    $types = $response->getProductTypesByCategory($category);

    echo "<h3>{$category}</h3>";
    echo "<ul>";
    foreach ($types as $type) {
        echo "<li><input type='radio' name='product_type' value='{$type->id}'> {$type->name}</li>";
    }
    echo "</ul>";
}
```

### 2. Validate Product Type ID

Ensure a product type ID is valid before creating a product:

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Product\ListProductTypesRequest;
use GoSuccess\Digistore24\Api\Request\Product\CreateProductRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

// Get available product types
$request = new ListProductTypesRequest();
$response = $client->products->listProductTypes($request);

// Validate user's selected product type
$selectedTypeId = 5; // From user input

$productType = $response->getProductTypeById($selectedTypeId);
if ($productType === null) {
    throw new InvalidArgumentException("Invalid product type ID: {$selectedTypeId}");
}

// Product type is valid, proceed with creation
$createRequest = new CreateProductRequest(
    nameIntern: 'my-product',
    productTypeId: $selectedTypeId
);

$product = $client->products->create($createRequest);
```

### 3. Cache Product Types

Cache product types to reduce API calls:

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Product\ListProductTypesRequest;

function getProductTypes(Digistore24 $client, bool $forceRefresh = false): array
{
    $cacheKey = 'digistore24_product_types';
    $cacheDuration = 86400; // 24 hours

    // Check cache (example using file cache)
    $cacheFile = sys_get_temp_dir() . '/' . $cacheKey . '.json';

    if (!$forceRefresh && file_exists($cacheFile)) {
        $cacheAge = time() - filemtime($cacheFile);
        if ($cacheAge < $cacheDuration) {
            $cached = json_decode(file_get_contents($cacheFile), true);
            return $cached;
        }
    }

    // Fetch fresh data
    $request = new ListProductTypesRequest();
    $response = $client->products->listProductTypes($request);

    $types = $response->productTypes;

    // Save to cache
    file_put_contents($cacheFile, json_encode($types));

    return $types;
}

// Usage
// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);
$productTypes = getProductTypes($client);
```

### 4. Filter by Category

Get only digital product types:

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Product\ListProductTypesRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

$request = new ListProductTypesRequest();
$response = $client->products->listProductTypes($request);

// Get only digital products
$digitalTypes = $response->getProductTypesByCategory('Digital');

echo "Available digital product types:\n";
foreach ($digitalTypes as $type) {
    echo "- {$type->name} (ID: {$type->id})\n";
}
```

### 5. Product Type Reference List

Generate a reference document of all product types:

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Product\ListProductTypesRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

$request = new ListProductTypesRequest();
$response = $client->products->listProductTypes($request);

$categories = array_values(array_unique(array_map(fn ($type) => $type->category, $response->productTypes)));

echo "# Digistore24 Product Types Reference\n\n";
echo "Generated: " . date('Y-m-d H:i:s') . "\n\n";

foreach ($categories as $category) {
    echo "## {$category}\n\n";

    $types = $response->getProductTypesByCategory($category);
    foreach ($types as $type) {
        echo "- **{$type->name}** (ID: `{$type->id}`)\n";
    }
    echo "\n";
}
```

### 6. Dynamic Product Creation Form

Build a dynamic form based on available product types:

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Product\ListProductTypesRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

$request = new ListProductTypesRequest();
$response = $client->products->listProductTypes($request);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Create New Product</title>
</head>
<body>
    <h1>Create New Product</h1>
    <form method="post" action="create-product.php">
        <div>
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" required>
        </div>

        <div>
            <label for="product_type">Product Type:</label>
            <select id="product_type" name="product_type_id" required>
                <option value="">-- Select Product Type --</option>
                <?php
                $categories = array_values(array_unique(array_map(fn ($type) => $type->category, $response->productTypes)));
                foreach ($categories as $category) {
                    echo "<optgroup label='{$category}'>";
                    $types = $response->getProductTypesByCategory($category);
                    foreach ($types as $type) {
                        echo "<option value='{$type->id}'>{$type->name}</option>";
                    }
                    echo "</optgroup>";
                }
                ?>
            </select>
        </div>

        <button type="submit">Create Product</button>
    </form>
</body>
</html>
```

## Error Handling

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Product\ListProductTypesRequest;
use GoSuccess\Digistore24\Api\Exception\ApiException;
use GoSuccess\Digistore24\Api\Exception\AuthenticationException;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$client = new Digistore24($config);

try {
    $request = new ListProductTypesRequest();
    $response = $client->products->listProductTypes($request);

    $types = $response->productTypes;

    if (empty($types)) {
        echo "Warning: No product types returned\n";
    } else {
        echo "Found " . count($types) . " product types\n";
    }

} catch (AuthenticationException $e) {
    echo "Authentication failed: " . $e->getMessage() . "\n";
    echo "Please check your API key.\n";

} catch (ApiException $e) {
    echo "API error: " . $e->getMessage() . "\n";
}
```

## Notes

- This endpoint does not require any parameters
- Product types are relatively stable and can be cached for extended periods (e.g., 24 hours)
- Product type IDs are integers and are consistent across API calls
- Categories help organize product types into logical groups (e.g., Digital, Physical, Service, Event)
- Use the returned product type IDs when creating or updating products with `createProduct` or `updateProduct`
- The list of product types may grow over time as Digistore24 adds new product categories

## Related Endpoints

- [createProduct](createProduct.md) - Create a new product (requires valid product_type_id)
- [updateProduct](updateProduct.md) - Update product settings (can change product_type_id)
- [getProduct](getProduct.md) - Get product details (includes product_type_id)
- [listProducts](listProducts.md) - List products (can filter by product_type_id)

## See Also

- [Products API Documentation](https://digistore24.com/api/docs#tag/Products)
- [Product Management Guide](https://digistore24.com/guide/products)
