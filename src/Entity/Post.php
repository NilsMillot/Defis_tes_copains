<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\TimesTampableTrait;


/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{

    use TimesTampableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToMany(targetEntity=Challenges::class, inversedBy="idPost")
     */
    private $challenge;

    /**
     * @ORM\OneToMany(targetEntity=Remark::class, mappedBy="post")
     */
    private $remark;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="likedPosts")
     */
    private $usersWhoLiked;

    /**
     * @ORM\OneToMany(targetEntity=UserLikePost::class, mappedBy="postLiked")
     */
    private $userLikePosts;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="postsId")
     * @ORM\JoinTable(name="post_by_user")
     */
    private $userId;

    public function __construct()
    {
        $this->challenge = new ArrayCollection();
        $this->usersWhoLiked = new ArrayCollection();
        $this->userLikePosts = new ArrayCollection();
        $this->userId = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getChallenge(): Collection
    {
        return $this->challenge;
    }

    public function addChallenge(Challenges $challenge): self
    {
        if (!$this->challenge->contains($challenge)) {
            $this->challenge[] = $challenge;
        }

        return $this;
    }

    public function removeChallenge(Challenges $challenge): self
    {
        $this->challenge->removeElement($challenge);

        return $this;
    }

    public function getRemark(): ?Remark
    {
        return $this->remark;
    }

    public function setRemark(?Remark $remark): self
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsersWhoLiked(): Collection
    {
        return $this->usersWhoLiked;
    }

    public function addUsersWhoLiked(User $usersWhoLiked): self
    {
        if (!$this->usersWhoLiked->contains($usersWhoLiked)) {
            $this->usersWhoLiked[] = $usersWhoLiked;
        }

        return $this;
    }

    public function removeUsersWhoLiked(User $usersWhoLiked): self
    {
        $this->usersWhoLiked->removeElement($usersWhoLiked);

        return $this;
    }

    /**
     * @return Collection|UserLikePost[]
     */
    public function getUserLikePosts(): Collection
    {
        return $this->userLikePosts;
    }

    public function addUserLikePost(UserLikePost $userLikePost): self
    {
        if (!$this->userLikePosts->contains($userLikePost)) {
            $this->userLikePosts[] = $userLikePost;
            $userLikePost->setPostLiked($this);
        }

        return $this;
    }

    public function removeUserLikePost(UserLikePost $userLikePost): self
    {
        if ($this->userLikePosts->removeElement($userLikePost)) {
            // set the owning side to null (unless already changed)
            if ($userLikePost->getPostLiked() === $this) {
                $userLikePost->setPostLiked(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserId(): Collection
    {
        return $this->userId;
    }

    public function addUserId(User $userId): self
    {
        if (!$this->userId->contains($userId)) {
            $this->userId[] = $userId;
        }

        return $this;
    }

    public function removeUserId(User $userId): self
    {
        $this->userId->removeElement($userId);

        return $this;
    }
}
