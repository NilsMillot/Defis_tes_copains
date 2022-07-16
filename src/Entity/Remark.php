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
     * @ORM\Column(type="text")
     */
    private $contentRemark;


    /**
     * @ORM\OneToMany(targetEntity=UserLikeRemark::class, mappedBy="remarkId")
     */
    private $userLikeRemarks;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="remark")
     */
    private $post;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="remarks")
     */
    private $userId;

    public function __construct()
    {
        $this->userLikeRemarks = new ArrayCollection();
        $this->userId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentRemark(): ?string
    {
        return $this->contentRemark;
    }

    public function setContentRemark(string $contentRemark): self
    {
        $this->contentRemark = $contentRemark;

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

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

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
