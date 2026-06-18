<?php

declare(strict_types=1);

/**
 * String-Backed Enum Interface & Trait Example
 *
 * This example demonstrates the standardized approach for all string-backed enums
 * in the Digistore24 API Client.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use GoSuccess\Digistore24\Api\Enum\Salutation;

echo "=== String-Backed Enum Interface & Trait Example ===\n\n";

// 1. Using label() method - Human-readable display
echo "1. Get human-readable labels:\n";
echo '   Salutation::MRS->label() = ' . Salutation::MRS->label() . "\n";
echo '   Salutation::MR->label() = ' . Salutation::MR->label() . "\n";
echo '   Salutation::NONE->label() = ' . Salutation::NONE->label() . "\n\n";

// 2. Using fromString() - Convert string to enum (case-insensitive)
echo "2. Convert string to enum (case-insensitive):\n";
$examples = ['F', 'f', 'M', 'm', '', 'invalid'];
foreach ($examples as $input) {
    $result = Salutation::fromString($input);
    $display = $input === '' ? "''" : $input;
    echo "   fromString($display) = ";
    if ($result === null) {
        echo "null\n";
    } else {
        echo $result->name . " ({$result->value}) - {$result->label()}\n";
    }
}
echo "\n";

// 3. Using isValid() - Validate before conversion
echo "3. Validate input before processing:\n";
$inputs = ['F', 'M', '', 'X', 'male', null];
foreach ($inputs as $input) {
    $display = $input === null ? 'null' : ($input === '' ? "''" : "'$input'");
    $valid = Salutation::isValid($input);
    echo "   isValid($display) = " . ($valid ? 'true' : 'false') . "\n";
}
echo "\n";

// 4. Using values() - Get all valid values (provided by trait)
echo "4. Get all valid enum values:\n";
echo "   Salutation::values() = ['" . implode("', '", Salutation::values()) . "']\n\n";

// 5. Using labels() - Get value => label map (provided by trait)
echo "5. Get value => label mapping:\n";
foreach (Salutation::labels() as $value => $label) {
    $display = $value === '' ? "''" : "'$value'";
    echo "   $display => '$label'\n";
}
echo "\n";

// 6. Using cases() - Native PHP enum method
echo "6. Iterate over all cases (native PHP method):\n";
foreach (Salutation::cases() as $case) {
    $valueDisplay = $case->value === '' ? "''" : "'{$case->value}'";
    echo "   {$case->name}: value=$valueDisplay, label='{$case->label()}'\n";
}
echo "\n";

// 7. Practical API usage example
echo "7. Practical API integration example:\n";
$apiData = ['salutation' => 'F', 'first_name' => 'Jane', 'last_name' => 'Doe'];

if (Salutation::isValid($apiData['salutation'])) {
    $salutation = Salutation::fromString($apiData['salutation']);
    echo "   Processing buyer: {$salutation->label()} {$apiData['first_name']} {$apiData['last_name']}\n";
} else {
    echo "   Invalid salutation in API data\n";
}
echo "\n";

// 8. Building select options for forms
echo "8. Generate form select options:\n";
echo "   <select name=\"salutation\">\n";
foreach (Salutation::cases() as $case) {
    $selected = $case === Salutation::NONE ? ' selected' : '';
    echo "       <option value=\"{$case->value}\"$selected>{$case->label()}</option>\n";
}
echo "   </select>\n\n";

echo "=== Benefits of this approach ===\n";
echo "✓ Consistent API across all enums\n";
echo "✓ Type-safe with interface contract\n";
echo "✓ Reduced code duplication via trait\n";
echo "✓ Easy to extend with additional helper methods\n";
echo "✓ PHPStan Level 9 compliant\n";
echo "✓ Works with all string-backed enums\n";
