<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
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
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="idPost")
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=Challenges::class, mappedBy="idPost")
     */
    private $challenge;

    /**
     * @ORM\ManyToOne(targetEntity=Remark::class, inversedBy="post")
     */
    private $remark;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="likedPosts")
     */
    private $usersWhoLiked;

    public function __construct()
    {
        $this->author = new ArrayCollection();
        $this->challenge = new ArrayCollection();
        $this->usersWhoLiked = new ArrayCollection();
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
     * @return Collection|User[]
     */
    public function getAuthor(): Collection
    {
        return $this->author;
    }

    public function addAuthor(User $author): self
    {
        if (!$this->author->contains($author)) {
            $this->author[] = $author;
            $author->setIdPost($this);
        }

        return $this;
    }

    public function removeAuthor(User $author): self
    {
        if ($this->author->removeElement($author)) {
            // set the owning side to null (unless already changed)
            if ($author->getIdPost() === $this) {
                $author->setIdPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Challenges[]
     */
    public function getChallenge(): Collection
    {
        return $this->challenge;
    }

    public function addChallenge(Challenges $challenge): self
    {
        if (!$this->challenge->contains($challenge)) {
            $this->challenge[] = $challenge;
            $challenge->setIdPost($this);
        }

        return $this;
    }

    public function removeChallenge(Challenges $challenge): self
    {
        if ($this->challenge->removeElement($challenge)) {
            // set the owning side to null (unless already changed)
            if ($challenge->getIdPost() === $this) {
                $challenge->setIdPost(null);
            }
        }

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
}
