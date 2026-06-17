<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Base;

use GoSuccess\Digistore24\Api\Contract\HttpClientInterface;
use GoSuccess\Digistore24\Api\Contract\RequestInterface;
use GoSuccess\Digistore24\Api\Contract\ResponseInterface;
use GoSuccess\Digistore24\Api\Enum\HttpStatusCode;
use GoSuccess\Digistore24\Api\Exception\ValidationException;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Abstract Resource Base Class
 *
 * Base class for all API resource classes.
 * Resources group related API endpoints together.
 */
abstract class AbstractResource
{
    public function __construct(
        protected readonly HttpClientInterface $client,
    ) {
    }

    /**
     * Execute a request and get the raw HTTP response.
     *
     * The request is validated against its own rules() before it is sent (throwing
     * a ValidationException on failure), so an invalid request fails fast locally
     * instead of round-tripping to the API.
     */
    protected function execute(RequestInterface $request): Response
    {
        $errors = $request->validate();
        if ($errors !== []) {
            $messages = [];
            foreach ($errors as $field => $fieldErrors) {
                $messages[] = $field . ': ' . implode(', ', $fieldErrors);
            }

            throw new ValidationException(
                'Request validation failed: ' . implode('; ', $messages),
                HttpStatusCode::BAD_REQUEST->value,
                ['errors' => $errors],
            );
        }

        $endpoint = $request->getEndpoint();
        $method = $request->getMethod();
        $data = $request->toArray();

        return $this->client->request($endpoint, $method, $data);
    }

    /**
     * Execute a request and parse it into a typed response.
     *
     * @template T of ResponseInterface
     * @param RequestInterface $request
     * @param class-string<T> $responseClass
     * @return T
     */
    protected function executeTyped(RequestInterface $request, string $responseClass): ResponseInterface
    {
        $response = $this->execute($request);

        return $responseClass::fromResponse($response);
    }
}
