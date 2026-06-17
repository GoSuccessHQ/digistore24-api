<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\PurchaseDownloadFileData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get Purchase Downloads Response
 *
 * Response containing download information for purchased digital products. The
 * API groups downloads by purchase ID and product ID. The raw grouped structure
 * is exposed via {@see self::$downloads}; typed file entries are available via
 * {@see self::$downloadsByPurchase} (grouped) and {@see self::$files} (flat).
 *
 * @link https://digistore24.com/api/docs/paths/getPurchaseDownloads.yaml
 */
final class GetPurchaseDownloadsResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * Raw downloads grouped by purchase ID and product ID.
     *
     * @var array<string, mixed>
     */
    public array $downloads = [];

    /**
     * Typed download files grouped by purchase ID and product ID.
     *
     * @var array<string, array<string, array<int, PurchaseDownloadFileData>>>
     */
    public array $downloadsByPurchase = [];

    /**
     * Flat list of every typed download file across all purchases and products.
     *
     * @var array<int, PurchaseDownloadFileData>
     */
    public array $files = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $downloads = $innerData['downloads'] ?? [];
        if (! is_array($downloads)) {
            $downloads = [];
        }
        /** @var array<string, mixed> $validatedDownloads */
        $validatedDownloads = $downloads;

        $byPurchase = [];
        $files = [];
        foreach ($validatedDownloads as $purchaseId => $products) {
            if (! is_array($products)) {
                continue;
            }
            foreach ($products as $productId => $fileEntries) {
                if (! is_array($fileEntries)) {
                    continue;
                }
                foreach ($fileEntries as $fileEntry) {
                    if (! is_array($fileEntry)) {
                        continue;
                    }
                    /** @var array<string, mixed> $entry */
                    $entry = self::toStringKeyedArray($fileEntry);
                    $file = PurchaseDownloadFileData::fromArray($entry);
                    $byPurchase[(string)$purchaseId][(string)$productId][] = $file;
                    $files[] = $file;
                }
            }
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->downloads = $validatedDownloads;
        $response->downloadsByPurchase = $byPurchase;
        $response->files = $files;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }

    /**
     * @param array<mixed, mixed> $value
     * @return array<string, mixed>
     */
    private static function toStringKeyedArray(array $value): array
    {
        $result = [];
        foreach ($value as $key => $item) {
            $result[(string)$key] = $item;
        }

        return $result;
    }
}
