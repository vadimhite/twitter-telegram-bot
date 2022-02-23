<?php

namespace App\Service\Twitter;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class Twitter.
 */
class Twitter
{
    /**
     * @var TwitterApp The twitter app entity
     */
    private TwitterApp $app;

    /**
     * @var TwitterClient The twitter client service
     */
    private TwitterClient $client;

    /**
     * @var string The callback url
     */
    private string $redirectUrl;

    /**
     * @param HttpClientInterface $httpClient
     * @param string              $twitterClientId
     * @param string              $twitterClientSecret
     * @param string              $redirectUrl
     */
    public function __construct(HttpClientInterface $httpClient, string $twitterClientId, string $twitterClientSecret, string $redirectUrl)
    {
        $this->app = new TwitterApp($twitterClientId, $twitterClientSecret);
        $this->client = new TwitterClient($httpClient);
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * Returns the twitter app entity.
     *
     * @return TwitterApp
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * Returns the twitter client service.
     *
     * @return TwitterClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Returns the OAuth 2.0 client service.
     *
     * @return OAuth2Client
     */
    public function getOAuth2Client()
    {
        return new OAuth2Client($this->app, $this->client, $this->redirectUrl);
    }
}
