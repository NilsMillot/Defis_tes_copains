<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\TimesTampableTrait;
use App\Entity\Traits\VichUploadTrait;
use Vich\UploaderBundle\Mapping\Annotation as Vich;



/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @Vich\Uploadable()
 */
class Post
{

    use TimesTampableTrait;
    use VichUploadTrait;


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
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity=UserLikePost::class, mappedBy="postLiked")
     */
    private $userLikePosts;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="postsId")
     * @ORM\JoinTable(name="post_by_user")
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity=Challenges::class, inversedBy="postId")
     */
    private $challengeId;

    /**
     * @ORM\OneToMany(targetEntity=Remark::class, mappedBy="post")
     */
    private $remark;

    /**
     * @ORM\OneToMany(targetEntity=Signalement::class, mappedBy="id_post")
     */
    private $signalements;

    public function __construct()
    {
        $this->usersWhoLiked = new ArrayCollection();
        $this->userLikePosts = new ArrayCollection();
        $this->userId = new ArrayCollection();
        $this->remark = new ArrayCollection();
        $this->signalements = new ArrayCollection();
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

    public function getChallengeId(): ?Challenges
    {
        return $this->challengeId;
    }

    public function setChallengeId(?Challenges $challengeId): self
    {
        $this->challengeId = $challengeId;

        return $this;
    }

    /**
     * @return Collection|Remark[]
     */
    public function getRemark(): Collection
    {
        return $this->remark;
    }

    public function addRemark(Remark $remark): self
    {
        if (!$this->remark->contains($remark)) {
            $this->remark[] = $remark;
            $remark->setPost($this);
        }

        return $this;
    }

    public function removeRemark(Remark $remark): self
    {
        if ($this->remark->removeElement($remark)) {
            // set the owning side to null (unless already changed)
            if ($remark->getPost() === $this) {
                $remark->setPost(null);
            }
        }

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $file)
    {
        $this->picture = $file;

        return $this;
    }

    /**
     * @return Collection<int, Signalement>
     */
    public function getSignalements(): Collection
    {
        return $this->signalements;
    }

    public function addSignalement(Signalement $signalement): self
    {
        if (!$this->signalements->contains($signalement)) {
            $this->signalements[] = $signalement;
            $signalement->setIdPost($this);
        }

        return $this;
    }

    public function removeSignalement(Signalement $signalement): self
    {
        if ($this->signalements->removeElement($signalement)) {
            // set the owning side to null (unless already changed)
            if ($signalement->getIdPost() === $this) {
                $signalement->setIdPost(null);
            }
        }

        return $this;
    }
}
