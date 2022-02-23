<?php

namespace App\Service\Twitter;

/**
 * Class TwitterApp.
 */
class TwitterApp
{
    /**
     * @var string The app id
     */
    private string $id;

    /**
     * @var string The app secret
     */
    private string $secret;

    /**
     * @param string $id
     * @param string $secret
     */
    public function __construct(string $id, string $secret)
    {
        $this->id = $id;
        $this->secret = $secret;
    }

    /**
     * Returns the app id.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Returns the app secret.
     *
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }
}
