<?php

namespace App\Entity;

use App\Repository\UserLikePostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserLikePostRepository::class)
 */
class UserLikePost
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userLikePosts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userWhoLiked;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="userLikePosts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $postLiked;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserWhoLiked(): ?User
    {
        return $this->userWhoLiked;
    }

    public function setUserWhoLiked(?User $userWhoLiked): self
    {
        $this->userWhoLiked = $userWhoLiked;

        return $this;
    }

    public function getPostLiked(): ?Post
    {
        return $this->postLiked;
    }

    public function setPostLiked(?Post $postLiked): self
    {
        $this->postLiked = $postLiked;

        return $this;
    }
}
