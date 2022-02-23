<?php

namespace App\Service\Twitter;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class TwitterClient.
 */
class TwitterClient
{
    /**
     * @const string The base twitter API url
     */
    public const BASE_API_URL = 'https://api.twitter.com/2';

    /**
     * @var HttpClientInterface The HTTP client handler
     */
    private HttpClientInterface $httpClient;

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Makes the request to twitter api and returns the result.
     *
     * @param TwitterRequest $request
     *
     * @return TwitterResponse
     */
    public function sendRequest(TwitterRequest $request): TwitterResponse
    {
        list($method, $url, $headers, $body) = $this->prepareRequest($request);

        $response = $this->httpClient->request($method, $url, ['headers' => $headers, 'body' => $body]);

        return new TwitterResponse(
            $request,
            $response->getStatusCode(),
            $response->getContent(false),
            $response->getHeaders(false)
        );
    }

    /**
     * Prepares the request for sending to the HTTP client handler.
     *
     * @param TwitterRequest $request
     *
     * @return array
     */
    private function prepareRequest(TwitterRequest $request)
    {
        $url = self::BASE_API_URL.$request->getPath();
        $request->setHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
        ]);

        return [
            $request->getMethod(),
            $url,
            $request->getHeaders(),
            $request->getParams(),
        ];
    }
}
