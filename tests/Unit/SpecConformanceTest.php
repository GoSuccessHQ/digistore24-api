<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit;

use FilesystemIterator;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Guards against drift between the SDK request classes and the Digistore24
 * OpenAPI spec (https://digistore24.com/api/docs/openapi.yaml).
 *
 * The four lists below freeze the spec's endpoint -> HTTP method mapping (122
 * endpoints). When Digistore24 changes the spec, update the relevant list; the
 * test then enforces that every request class uses the right verb and that every
 * endpoint is covered by exactly one request class. This deliberately avoids a
 * live HTTP call so the check is deterministic in CI.
 */
final class SpecConformanceTest extends TestCase
{
    /** @var list<string> */
    private const GET = [
        'getAffiliateCommission', 'getBuyer', 'getDelivery', 'getEticket', 'getEticketSettings', 'getGlobalSettings',
        'getImage', 'getMarketplaceEntry', 'getServiceProofRequest', 'getOrderform', 'getOrderformMetas', 'getProduct',
        'getProductGroup', 'getShippingCostPolicy', 'getPurchase', 'getCustomerToAffiliateBuyerDetails', 'getPurchaseTracking',
        'getPurchaseDownloads', 'getReferringAffiliate', 'getSmartupgrade', 'getUpgrade', 'getUpsells', 'getUserInfo', 'getVoucher',
        'ipnInfo', 'listAccountAccess', 'listBuyers', 'listBuyUrls', 'listCommissions', 'listConversionTools', 'listCountries',
        'listCurrencies', 'listEticketLocations', 'listCustomFormRecords', 'listEticketTemplates', 'listServiceProofRequests',
        'listDeliveries', 'listEtickets', 'listImages', 'listInvoices', 'listMarketplaceEntries', 'listOrderforms',
        'listPurchasesOfEmail', 'listPaymentPlans', 'listPayouts', 'listProductGroups', 'listShippingCostPolicies', 'listProducts',
        'listProductTypes', 'listPurchases', 'listRebillingStatusChanges', 'listSmartUpgrades', 'ping', 'renderJsTrackingCode',
        'statsAffiliateToplist', 'statsDailyAmounts', 'statsExpectedPayouts', 'statsMarketplace', 'statsSales', 'statsSalesSummary',
        'validateAffiliate', 'validateCouponCode', 'validateEticket', 'validateLicenseKey',
    ];

    /** @var list<string> */
    private const PUT = [
        'updateAffiliateCommission', 'updateBuyer', 'updateDelivery', 'updateOrderform', 'updatePaymentplan', 'updateProduct',
        'updateProductGroup', 'updatePurchase', 'updateServiceProofRequest', 'updateShippingCostPolicy', 'updateUpsells', 'updateVoucher',
    ];

    /** @var list<string> */
    private const DELETE = [
        'deleteBuyUrl', 'deleteImage', 'deleteOrderform', 'deletePaymentplan', 'deleteProduct', 'deleteProductGroup',
        'deleteShippingCostPolicy', 'deleteUpgrade', 'deleteUpsells', 'deleteVoucher', 'ipnDelete', 'unregister',
    ];

    /** @var list<string> */
    private const POST = [
        'addBalanceToPurchase', 'copyProduct', 'logMemberAccess', 'createBillingOnDemand', 'createAddonChangePurchase', 'createBuyUrl',
        'createImage', 'createEticket', 'createOrderform', 'createPaymentplan', 'createProduct', 'createProductGroup',
        'createShippingCostPolicy', 'createUpgrade', 'createUpgradePurchase', 'createVoucher', 'ipnSetup', 'listTransactions',
        'listUpgrades', 'listVouchers', 'getAffiliateForEmail', 'createRebillingPayment', 'refundPartially', 'refundPurchase',
        'refundTransaction', 'reportFraud', 'requestApiKey', 'resendInvoiceMail', 'resendPurchaseConfirmationMail', 'retrieveApiKey',
        'setAffiliateForEmail', 'setReferringAffiliate', 'startRebilling', 'stopRebilling',
    ];

    public function test_every_request_class_uses_the_spec_http_method(): void
    {
        $expected = $this->expectedMethods();

        foreach ($this->requestSources() as $file => $source) {
            $endpoint = $this->extractEndpoint($source);
            $this->assertNotNull($endpoint, "Could not find a getEndpoint() literal in {$file}");
            $this->assertArrayHasKey($endpoint, $expected, "Request class {$file} targets unknown endpoint /{$endpoint}");

            $this->assertSame(
                $expected[$endpoint],
                $this->extractMethod($source),
                sprintf('%s (/%s) must use HTTP %s per the spec', basename($file), $endpoint, $expected[$endpoint]),
            );
        }
    }

    public function test_every_spec_endpoint_has_a_request_class(): void
    {
        $covered = [];
        foreach ($this->requestSources() as $source) {
            $endpoint = $this->extractEndpoint($source);
            if ($endpoint !== null) {
                $covered[$endpoint] = true;
            }
        }

        foreach (array_keys($this->expectedMethods()) as $endpoint) {
            $this->assertArrayHasKey($endpoint, $covered, "No request class implements /{$endpoint}");
        }
    }

    public function test_spec_map_covers_122_endpoints(): void
    {
        $this->assertCount(122, $this->expectedMethods());
    }

    /**
     * @return array<string, string> endpoint (without leading slash) => HTTP method
     */
    private function expectedMethods(): array
    {
        $map = [];
        foreach (['GET' => self::GET, 'PUT' => self::PUT, 'DELETE' => self::DELETE, 'POST' => self::POST] as $method => $endpoints) {
            foreach ($endpoints as $endpoint) {
                $map[$endpoint] = $method;
            }
        }

        return $map;
    }

    /**
     * @return iterable<string, string> file path => source code
     */
    private function requestSources(): iterable
    {
        $dir = __DIR__ . '/../../src/Request';
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS));

        foreach ($iterator as $file) {
            if (! $file instanceof \SplFileInfo || $file->getExtension() !== 'php') {
                continue;
            }

            yield $file->getPathname() => (string)file_get_contents($file->getPathname());
        }
    }

    private function extractEndpoint(string $source): ?string
    {
        if (preg_match("/getEndpoint\\(\\): string\\s*\\{\\s*return '\\/([A-Za-z0-9_]+)'/s", $source, $matches) === 1) {
            return $matches[1];
        }

        return null;
    }

    private function extractMethod(string $source): string
    {
        if (preg_match('/getMethod\(\): HttpMethod\s*\{\s*return HttpMethod::(\w+)/s', $source, $matches) === 1) {
            return $matches[1];
        }

        return 'POST'; // AbstractRequest default
    }
}
