<?php

namespace App\Service\Twitter;

/**
 * Class OAuth2Client.
 */
class OAuth2Client
{
    /**
     * @const string The twitter authorization endpoint
     */
    public const AUTHORIZATION_ENDPOINT = 'https://twitter.com/i/oauth2/authorize';

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
     * @param TwitterApp    $twitterApp
     * @param TwitterClient $twitterClient
     * @param string        $redirectUrl
     */
    public function __construct(TwitterApp $twitterApp, TwitterClient $twitterClient, string $redirectUrl)
    {
        $this->app = $twitterApp;
        $this->client = $twitterClient;
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * Generates and returns a twitter authorization URL to begin the process of authenticating a user.
     *
     * @param array $scope An array of permissions to request
     *
     * @return string
     */
    public function getAuthorizationUrl(array $scope = []): string
    {
        // @todo create a random code generator for the code_challenge parameter
        $params = [
            'response_type' => 'code',
            'client_id' => $this->app->getId(),
            'redirect_uri' => $this->redirectUrl,
            'scope' => implode(' ', $scope),
            'state' => 'state',
            'code_challenge' => 'challenge',
            'code_challenge_method' => 'plain',
        ];

        return self::AUTHORIZATION_ENDPOINT.'?'.http_build_query($params);
    }

    /**
     * Gets a valid access token from a code.
     *
     * @param string $code
     *
     * @return AccessToken
     */
    public function getAccessTokenFromCode(string $code): AccessToken
    {
        $params = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->redirectUrl,
            'code_verifier' => 'challenge',
        ];

        return $this->requestAnAccessToken($params);
    }

    /**
     * Refreshes and returns a new access token.
     *
     * @param AccessToken|string $token
     *
     * @return AccessToken
     */
    public function refreshAccessToken($token): AccessToken
    {
        $refreshToken = $token instanceof AccessToken ? $token->getRefreshToken() : $token;
        $params = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ];

        return $this->requestAnAccessToken($params);
    }

    /**
     * Sends a request to the OAuth2 endpoint and returns a valid access token.
     *
     * @param array $params
     *
     * @return AccessToken
     */
    private function requestAnAccessToken(array $params): AccessToken
    {
        $response = $this->sendRequestWithClientParams('/oauth2/token', $params);
        $data = $response->getDecodedBody();
        $expiresAt = time() + $data['expires_in'];

        return new AccessToken($data['access_token'], $expiresAt, $data['refresh_token'] ?? null);
    }

    /**
     * Sends a request to the twitter API with the basic authentication HTTP header.
     *
     * @param string $endpoint
     * @param array  $params
     *
     * @return TwitterResponse
     */
    private function sendRequestWithClientParams(string $endpoint, array $params): TwitterResponse
    {
        $basicAuthTypeAndToken = ['basic' => $this->makeBasicAuthToken()];
        $request = new TwitterRequest('POST', $endpoint, $basicAuthTypeAndToken, $params);

        return $this->client->sendRequest($request);
    }

    /**
     * Generates a basic authorization token.
     *
     * @return string
     */
    private function makeBasicAuthToken(): string
    {
        return base64_encode($this->app->getId().':'.$this->app->getSecret());
    }
}
