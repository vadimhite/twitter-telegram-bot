<?php

namespace App\Service\Twitter;

/**
 * Class TwitterResponse.
 */
class TwitterResponse
{
    /**
     * @var TwitterRequest The original request that returned this response
     */
    private TwitterRequest $request;

    /**
     * @var int The HTTP status code response from twitter API
     */
    private int $httpStatusCode;

    /**
     * @var string The raw body of the response from twitter API
     */
    private string $body;

    /**
     * @var array The headers returned from twitter API
     */
    private array $headers;

    /**
     * @var array The decoded body of the twitter API response
     */
    private array $decodedBody = [];

    /**
     * @param TwitterRequest $request
     * @param int            $httpStatusCode
     * @param string         $body
     * @param array          $headers
     */
    public function __construct(TwitterRequest $request, int $httpStatusCode, string $body, array $headers = [])
    {
        $this->request = $request;
        $this->httpStatusCode = $httpStatusCode;
        $this->body = $body;
        $this->headers = $headers;

        $this->decodeBody();
    }

    /**
     * Returns the original request that returned this response.
     *
     * @return TwitterRequest
     */
    public function getRequest(): TwitterRequest
    {
        return $this->request;
    }

    /**
     * Returns the raw response body.
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Returns the HTTP status code for this response.
     *
     * @return int
     */
    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    /**
     * Returns the HTTP headers for this response.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Returns the decoded response body.
     *
     * @return array
     */
    public function getDecodedBody(): array
    {
        return $this->decodedBody;
    }

    /**
     * Convert the raw response into an array.
     */
    public function decodeBody()
    {
        $this->decodedBody = json_decode($this->body, true);
    }
}
