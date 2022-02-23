<?php

namespace App\Service\Twitter;

/**
 * Class TwitterRequest.
 */
class TwitterRequest
{
    /**
     * @var string The HTTP method for this request
     */
    private string $method;

    /**
     * @var string The twitter API endpoint for this request
     */
    private string $path;

    /**
     * @var array Contains the authentication type as the key and the token as the value. Example: ['bearer' => %token%]
     */
    private array $tokenByAuthType;

    /**
     * @var array The parameters to send with this request
     */
    private array $params;

    /**
     * @var array The headers to send with this request
     */
    private array $headers = [];

    /**
     * @param string $method
     * @param string $path
     * @param array  $tokenByAuthType
     * @param array  $params
     */
    public function __construct(string $method, string $path, array $tokenByAuthType, array $params = [])
    {
        $this->method = $method;
        $this->path = $path;
        $this->tokenByAuthType = $tokenByAuthType;
        $this->params = $params;
    }

    /**
     * Returns the HTTP method for this request.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Returns the url path to twitter api for this request.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Returns params for this request.
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Returns the headers for this request.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        $authHeader = $this->getAuthHeader();

        return array_merge($authHeader, $this->headers);
    }

    /**
     * Sets the headers for this request.
     *
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    /**
     * Generates and returns authentication header by authentication type.
     *
     * @return array
     */
    private function getAuthHeader(): array
    {
        $tokenByAuthType = $this->tokenByAuthType;
        $result = 'bearer' === strtolower(key($tokenByAuthType))
            ? 'Bearer '.current($tokenByAuthType)
            : 'Basic '.current($tokenByAuthType);

        return ['Authorization' => $result];
    }
}
