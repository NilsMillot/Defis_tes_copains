<?php

namespace App\Entity;

use App\Repository\UserLikeRemarkRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserLikeRemarkRepository::class)
 */
class UserLikeRemark
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userLikeRemarks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity=Remark::class, inversedBy="userLikeRemarks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $remarkId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getRemarkId(): ?Remark
    {
        return $this->remarkId;
    }

    public function setRemarkId(?Remark $remarkId): self
    {
        $this->remarkId = $remarkId;

        return $this;
    }
}
