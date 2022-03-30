<?php

namespace App\Entity;

use App\Repository\TwitterUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TwitterUserRepository::class)
 */
class TwitterUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $uid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expiresAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $refreshToken;

    /**
     * @ORM\OneToMany(targetEntity=TelegramUser::class, mappedBy="twitterUser", orphanRemoval=true)
     */
    private $telegramUsers;

    /**
     * @param int $uid
     */
    public function __construct(int $uid)
    {
        $this->uid = $uid;
        $this->telegramUsers = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getUid(): ?int
    {
        return $this->uid;
    }

    /**
     * Returns the twitter user access token.
     *
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Sets the twitter user access token.
     *
     * @param string $token
     *
     * @return $this
     */
    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Returns the date when the access token expires.
     *
     * @return \DateTimeInterface|null
     */
    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expiresAt;
    }

    /**
     * Sets the date when the access token expires.
     *
     * @param \DateTimeInterface $expiresAt
     *
     * @return $this
     */
    public function setExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * Returns a token to refresh the access token.
     *
     * @return string|null
     */
    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    /**
     * Sets a token to refresh the access token.
     *
     * @param string|null $refreshToken
     *
     * @return $this
     */
    public function setRefreshToken(?string $refreshToken): self
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    /**
     * @return Collection|TelegramUser[]
     */
    public function getTelegramUsers(): Collection
    {
        return $this->telegramUsers;
    }

    /**
     * @param TelegramUser $telegramUser
     *
     * @return $this
     */
    public function addTelegramUser(TelegramUser $telegramUser): self
    {
        if (!$this->telegramUsers->contains($telegramUser)) {
            $this->telegramUsers[] = $telegramUser;
            $telegramUser->setTwitterUser($this);
        }

        return $this;
    }

    /**
     * @param TelegramUser $telegramUser
     *
     * @return $this
     */
    public function removeTelegramUser(TelegramUser $telegramUser): self
    {
        if ($this->telegramUsers->removeElement($telegramUser)) {
            // set the owning side to null (unless already changed)
            if ($telegramUser->getTwitterUser() === $this) {
                $telegramUser->setTwitterUser(null);
            }
        }

        return $this;
    }
}
