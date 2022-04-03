<?php

namespace App\Entity;

use App\Repository\FriendsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FriendsRepository::class)
 */
class Friends
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="friendRequestSent")
     * @ORM\JoinColumn(nullable=false)
     */
    private $senderUser;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="friendRequestReceived")
     * @ORM\JoinColumn(nullable=false)
     */
    private $receiverUser;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSenderUser(): ?User
    {
        return $this->senderUser;
    }

    public function setSenderUser(?User $senderUser): self
    {
        $this->senderUser = $senderUser;

        return $this;
    }

    public function getReceiverUser(): ?User
    {
        return $this->receiverUser;
    }

    public function setReceiverUser(?User $receiverUser): self
    {
        $this->receiverUser = $receiverUser;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
