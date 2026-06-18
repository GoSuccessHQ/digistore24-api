<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use GoSuccess\Digistore24\Api\DTO\BuyerData;
use GoSuccess\Digistore24\Api\Enum\Salutation;

echo "=== Salutation Enum Usage Examples ===\n\n";

// Example 1: Using Enum values directly
echo "1. Using Enum values directly:\n";
$buyer1 = new BuyerData();
$buyer1->email = 'john.doe@example.com';
$buyer1->salutation = Salutation::MR;
$buyer1->firstName = 'John';
$buyer1->lastName = 'Doe';

echo '   Salutation value: ' . $buyer1->salutation->value . "\n";
echo '   Salutation label: ' . $buyer1->salutation->label() . "\n\n";

// Example 2: Female salutation
echo "2. Female salutation:\n";
$buyer2 = new BuyerData();
$buyer2->email = 'jane.smith@example.com';
$buyer2->salutation = Salutation::MRS;
$buyer2->firstName = 'Jane';
$buyer2->lastName = 'Smith';

echo '   Salutation value: ' . $buyer2->salutation->value . "\n";
echo '   Salutation label: ' . $buyer2->salutation->label() . "\n\n";

// Example 3: No salutation
echo "3. No salutation:\n";
$buyer3 = new BuyerData();
$buyer3->email = 'alex.jones@example.com';
$buyer3->salutation = Salutation::NONE;
$buyer3->firstName = 'Alex';
$buyer3->lastName = 'Jones';

echo "   Salutation value: '" . $buyer3->salutation->value . "' (empty string)\n";
$buyer3->salutation->label() . "\n\n";

// Example 4: Converting from string
echo "4. Converting from string (case-insensitive):\n";
$salutationF = Salutation::fromString('f');
$salutationM = Salutation::fromString('M');
$salutationEmpty = Salutation::fromString('');
$salutationInvalid = Salutation::fromString('X');

echo "   'f' -> " . ($salutationF ? $salutationF->label() : 'null') . "\n";
echo "   'M' -> " . ($salutationM ? $salutationM->label() : 'null') . "\n";
echo "   '' -> " . ($salutationEmpty ? $salutationEmpty->label() : 'null') . "\n";
echo "   'X' -> " . ($salutationInvalid ? $salutationInvalid->label() : 'null (invalid)') . "\n\n";

// Example 5: Validation
echo "5. Validating salutation values:\n";
echo "   'F' is valid: " . (Salutation::isValid('F') ? 'Yes' : 'No') . "\n";
echo "   'M' is valid: " . (Salutation::isValid('M') ? 'Yes' : 'No') . "\n";
echo "   '' is valid: " . (Salutation::isValid('') ? 'Yes' : 'No') . "\n";
echo "   'X' is valid: " . (Salutation::isValid('X') ? 'Yes' : 'No') . "\n";
echo '   null is valid: ' . (Salutation::isValid(null) ? 'Yes' : 'No') . "\n\n";

// Example 6: Using in API context (simulated)
echo "6. Simulating API response processing:\n";
$apiResponse = [
    'email' => 'customer@example.com',
    'salutation' => 'F',
    'first_name' => 'Maria',
    'last_name' => 'Garcia',
];

$buyer = new BuyerData();
$buyer->email = $apiResponse['email'];
$buyer->salutation = Salutation::fromString($apiResponse['salutation']);
$buyer->firstName = $apiResponse['first_name'];
$buyer->lastName = $apiResponse['last_name'];

echo '   Processed: ' . $buyer->salutation?->label() . ' ' .
     $buyer->firstName . ' ' . $buyer->lastName . "\n";
echo '   Email: ' . $buyer->email . "\n\n";

// Example 7: Matching on enum
echo "7. Using match expression:\n";
$buyer4 = new BuyerData();
$buyer4->email = 'test@example.com';
$buyer4->salutation = Salutation::MRS;

$greeting = match ($buyer4->salutation) {
    Salutation::MR => 'Dear Sir',
    Salutation::MRS => 'Dear Madam',
    Salutation::NONE, null => 'Dear Customer',
};

echo "   Greeting: $greeting\n\n";

echo "=== All examples completed successfully! ===\n";
