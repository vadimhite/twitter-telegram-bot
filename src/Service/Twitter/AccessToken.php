<?php

namespace App\Service\Twitter;

/**
 * Class AccessToken.
 */
class AccessToken
{
    /**
     * @var string The access token value
     */
    private string $value;

    /**
     * @var \DateTime Date when token expires
     */
    private \DateTime $expiresAt;

    /**
     * @var string|null The token to refresh the access token
     */
    private ?string $refreshToken;

    /**
     * @param string      $accessToken
     * @param int         $expiresAt
     * @param string|null $refreshToken
     */
    public function __construct(string $accessToken, int $expiresAt, ?string $refreshToken)
    {
        $this->value = $accessToken;
        $this->setExpiresAtFromTimestamp($expiresAt);
        $this->refreshToken = $refreshToken;
    }

    /**
     * Returns the access token as a string.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Getter for expiresAt.
     *
     * @return \DateTime
     */
    public function getExpiresAt(): \DateTime
    {
        return $this->expiresAt;
    }

    /**
     * Returns the refresh token as a string if it was set, null otherwise.
     *
     * @return string|null
     */
    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    /**
     * Checks the expiration of the access token.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->expiresAt->getTimestamp() < time();
    }

    /**
     * Checks whether or not a refresh token exists.
     *
     * @return bool
     */
    public function hasRefreshToken(): bool
    {
        return (bool) $this->refreshToken;
    }

    /**
     * Setter for expiresAt.
     *
     * @param int $timestamp
     */
    private function setExpiresAtFromTimestamp(int $timestamp)
    {
        $dateTime = new \DateTime();
        $dateTime->setTimestamp($timestamp);
        $this->expiresAt = $dateTime;
    }
}
