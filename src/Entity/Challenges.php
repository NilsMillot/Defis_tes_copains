<?php

namespace App\Entity;

use App\Repository\ChallengesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChallengesRepository::class)
 */
class Challenges
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
     * @ORM\Column(type="datetime")
     */
    private $creation_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deadline;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $qr_code;

    /**
     * @ORM\OneToMany(targetEntity=CategoryChallenges::class, mappedBy="idChallenge")
     */
    private $categoryChallenges;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="challenge")
     */
    private $idPost;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="challenge")
     */
    private $users;

    public function __construct()
    {
        $this->categoryChallenges = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(?\DateTimeInterface $deadline): self
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getQrCode(): ?string
    {
        return $this->qr_code;
    }

    public function setQrCode(?string $qr_code): self
    {
        $this->qr_code = $qr_code;

        return $this;
    }

    /**
     * @return Collection|CategoryChallenges[]
     */
    public function getCategoryChallenges(): Collection
    {
        return $this->categoryChallenges;
    }

    public function addCategoryChallenge(CategoryChallenges $categoryChallenge): self
    {
        if (!$this->categoryChallenges->contains($categoryChallenge)) {
            $this->categoryChallenges[] = $categoryChallenge;
            $categoryChallenge->setIdChallenge($this);
        }

        return $this;
    }

    public function removeCategoryChallenge(CategoryChallenges $categoryChallenge): self
    {
        if ($this->categoryChallenges->removeElement($categoryChallenge)) {
            // set the owning side to null (unless already changed)
            if ($categoryChallenge->getIdChallenge() === $this) {
                $categoryChallenge->setIdChallenge(null);
            }
        }

        return $this;
    }

    public function getIdPost(): ?Post
    {
        return $this->idPost;
    }

    public function setIdPost(?Post $idPost): self
    {
        $this->idPost = $idPost;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addChallenge($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeChallenge($this);
        }

        return $this;
    }
}
