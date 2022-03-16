<?php

namespace App\Entity;

use App\Repository\RemarkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RemarkRepository::class)
 */
class Remark
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="remark")
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="remark")
     */
    private $post;

    /**
     * @ORM\OneToMany(targetEntity=UserLikeRemark::class, mappedBy="remarkId")
     */
    private $userLikeRemarks;

    public function __construct()
    {
        $this->userId = new ArrayCollection();
        $this->post = new ArrayCollection();
        $this->userRemark = new ArrayCollection();
        $this->userLikeRemarks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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
            $userId->setRemark($this);
        }

        return $this;
    }

    public function removeUserId(User $userId): self
    {
        if ($this->userId->removeElement($userId)) {
            // set the owning side to null (unless already changed)
            if ($userId->getRemark() === $this) {
                $userId->setRemark(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPost(): Collection
    {
        return $this->post;
    }

    public function addPost(Post $post): self
    {
        if (!$this->post->contains($post)) {
            $this->post[] = $post;
            $post->setRemark($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->post->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getRemark() === $this) {
                $post->setRemark(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserRemark(): Collection
    {
        return $this->userRemark;
    }

    public function addUserRemark(User $userRemark): self
    {
        if (!$this->userRemark->contains($userRemark)) {
            $this->userRemark[] = $userRemark;
        }

        return $this;
    }

    public function removeUserRemark(User $userRemark): self
    {
        $this->userRemark->removeElement($userRemark);

        return $this;
    }

    /**
     * @return Collection|UserLikeRemark[]
     */
    public function getUserLikeRemarks(): Collection
    {
        return $this->userLikeRemarks;
    }

    public function addUserLikeRemark(UserLikeRemark $userLikeRemark): self
    {
        if (!$this->userLikeRemarks->contains($userLikeRemark)) {
            $this->userLikeRemarks[] = $userLikeRemark;
            $userLikeRemark->setRemarkId($this);
        }

        return $this;
    }

    public function removeUserLikeRemark(UserLikeRemark $userLikeRemark): self
    {
        if ($this->userLikeRemarks->removeElement($userLikeRemark)) {
            // set the owning side to null (unless already changed)
            if ($userLikeRemark->getRemarkId() === $this) {
                $userLikeRemark->setRemarkId(null);
            }
        }

        return $this;
    }
}
