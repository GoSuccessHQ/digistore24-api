<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Ipn;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\IpnNewsletterSendPolicy;
use GoSuccess\Digistore24\Api\Enum\IpnTiming;
use GoSuccess\Digistore24\Api\Enum\IpnTransactionCategory;
use GoSuccess\Digistore24\Api\Enum\IpnTransactionType;

/**
 * IPN Setup Request
 *
 * Sets up an IPN (Instant Payment Notification) endpoint for receiving payment notifications.
 */
final class IpnSetupRequest extends AbstractRequest
{
    /**
     * @param string $ipnUrl URL where Digistore24 sends the IPN notification
     * @param string $name The name listed on Digistore (e.g. your platform name)
     * @param string $productIds "all" or a comma-separated list of product IDs
     * @param string|null $domainId Used to delete the IPN connection and ensure uniqueness. Usually your platform name
     * @param array<IpnTransactionCategory>|null $categories Transaction categories to receive notifications for
     * @param array<IpnTransactionType> $transactions Transaction types to receive notifications for
     * @param IpnTiming $timing Controls when the IPN notification is sent
     * @param string|null $shaPassphrase Password for signing parameters. Use "random" for auto-generated 30-char password
     * @param IpnNewsletterSendPolicy $newsletterSendPolicy Controls when to send IPN based on newsletter opt-in status
     */
    public function __construct(
        private string $ipnUrl,
        private string $name,
        private string $productIds,
        private ?string $domainId = null,
        private ?array $categories = null,
        private array $transactions = [
            IpnTransactionType::PAYMENT,
            IpnTransactionType::REFUND,
            IpnTransactionType::CHARGEBACK,
            IpnTransactionType::PAYMENT_MISSED,
        ],
        private IpnTiming $timing = IpnTiming::BEFORE_THANKYOU,
        private ?string $shaPassphrase = null,
        private IpnNewsletterSendPolicy $newsletterSendPolicy = IpnNewsletterSendPolicy::SEND_ALWAYS,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/ipnSetup';
    }

    public function toArray(): array
    {
        $params = [
            'ipn_url' => $this->ipnUrl,
            'name' => $this->name,
            'product_ids' => $this->productIds,
            'transactions' => implode(',', array_map(fn (IpnTransactionType $type) => $type->value, $this->transactions)),
            'timing' => $this->timing->value,
            'newsletter_send_policy' => $this->newsletterSendPolicy->value,
        ];

        if ($this->domainId !== null) {
            $params['domain_id'] = $this->domainId;
        }

        if ($this->categories !== null) {
            $params['categories'] = implode(',', array_map(fn (IpnTransactionCategory $cat) => $cat->value, $this->categories));
        }

        if ($this->shaPassphrase !== null) {
            $params['sha_passphrase'] = $this->shaPassphrase;
        }

        return $params;
    }
}
