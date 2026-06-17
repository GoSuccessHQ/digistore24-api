<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Purchase;

use GoSuccess\Digistore24\Api\DTO\PurchaseDownloadFileData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Purchase\GetPurchaseDownloadsResponse;
use PHPUnit\Framework\TestCase;

final class GetPurchaseDownloadsResponseTest extends TestCase
{
    /**
     * @return array<string, mixed>
     */
    private function sampleDownloads(): array
    {
        return [
            'data' => [
                'downloads' => [
                    'P123456' => [
                        '789' => [
                            [
                                'url' => 'https://example.com/download/ebook.pdf',
                                'downloads_total' => 5,
                                'downloads_tries' => 1,
                                'is_access_granted' => 'Y',
                                'is_purchase_paid' => 'Y',
                                'headline' => 'Your eBook',
                                'instructions' => 'Click to download',
                                'file_name' => 'ebook',
                                'file_ext' => 'pdf',
                                'file_size' => 102400,
                                'download_until' => '2024-12-31',
                            ],
                            [
                                'url' => 'https://example.com/download/video.mp4',
                                'is_access_granted' => 'N',
                                'is_purchase_paid' => 'Y',
                                'file_name' => 'video',
                                'file_ext' => 'mp4',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function test_can_create_from_array(): void
    {
        $response = GetPurchaseDownloadsResponse::fromArray($this->sampleDownloads());

        $this->assertInstanceOf(GetPurchaseDownloadsResponse::class, $response);

        // Raw grouped structure is preserved.
        $this->assertArrayHasKey('P123456', $response->downloads);

        // Flat typed list of all files.
        $this->assertCount(2, $response->files);
        $this->assertInstanceOf(PurchaseDownloadFileData::class, $response->files[0]);
        $this->assertSame('https://example.com/download/ebook.pdf', $response->files[0]->url);
        $this->assertSame(5, $response->files[0]->downloadsTotal);
        $this->assertSame(1, $response->files[0]->downloadsTries);
        $this->assertTrue($response->files[0]->isAccessGranted);
        $this->assertTrue($response->files[0]->isPurchasePaid);
        $this->assertSame('ebook', $response->files[0]->fileName);
        $this->assertSame('pdf', $response->files[0]->fileExt);
        $this->assertSame(102400, $response->files[0]->fileSize);
        $this->assertSame('2024-12-31', $response->files[0]->downloadUntil);
        $this->assertFalse($response->files[1]->isAccessGranted);

        // Grouped typed structure by purchase ID and product ID.
        $this->assertArrayHasKey('P123456', $response->downloadsByPurchase);
        $productGroups = array_values($response->downloadsByPurchase['P123456']);
        $this->assertCount(1, $productGroups);
        $files = $productGroups[0];
        $this->assertCount(2, $files);
        $this->assertSame('video', $files[1]->fileName);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => $this->sampleDownloads(),
            ],
            headers: [],
            rawBody: '',
        );

        $response = GetPurchaseDownloadsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(GetPurchaseDownloadsResponse::class, $response);
        $this->assertCount(2, $response->files);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'downloads' => [],
                ],
            ],
            headers: [],
            rawBody: 'test',
        );

        $response = GetPurchaseDownloadsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
