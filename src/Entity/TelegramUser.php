<?php

namespace App\Entity;

use App\Repository\TelegramUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TelegramUserRepository::class)
 */
class TelegramUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $uid;

    /**
     * @ORM\ManyToOne(targetEntity=TwitterUser::class, inversedBy="telegramUsers")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="uid")
     */
    private $twitterUser;

    /**
     * @param int $uid
     */
    public function __construct(int $uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return int|null
     */
    public function getUid(): ?int
    {
        return $this->uid;
    }

    /**
     * @return TwitterUser|null
     */
    public function getTwitterUser(): ?TwitterUser
    {
        return $this->twitterUser;
    }

    /**
     * @param TwitterUser|null $twitterUser
     *
     * @return $this
     */
    public function setTwitterUser(?TwitterUser $twitterUser): self
    {
        $this->twitterUser = $twitterUser;

        return $this;
    }
}
