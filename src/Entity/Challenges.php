<?php

namespace App\Entity;

use App\Repository\ChallengesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Traits\VichUploadTrait;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ChallengesRepository::class)
 * @Vich\Uploadable()
 */
class Challenges implements \Serializable
{

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creation_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deadline;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $qr_code;


    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="challenge")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="challengeId")
     */
    private $postId;

    /**
     * @ORM\OneToMany(targetEntity=ChallengesUserRegister::class, mappedBy="challengeRegister")
     */
    private $challengesUserRegisters;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="challenges")
     */
    private $category;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->postId = new ArrayCollection();
        $this->challengesUserRegisters = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $file )
    {
        $this->picture = $file;

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

    /**
     * @return Collection|Post[]
     */
    public function getPostId(): Collection
    {
        return $this->postId;
    }

    public function addPostId(Post $postId): self
    {
        if (!$this->postId->contains($postId)) {
            $this->postId[] = $postId;
            $postId->setChallengeId($this);
        }

        return $this;
    }

    public function removePostId(Post $postId): self
    {
        if ($this->postId->removeElement($postId)) {
            // set the owning side to null (unless already changed)
            if ($postId->getChallengeId() === $this) {
                $postId->setChallengeId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ChallengesUserRegister[]
     */
    public function getChallengesUserRegisters(): Collection
    {
        return $this->challengesUserRegisters;
    }

    public function addChallengesUserRegister(ChallengesUserRegister $challengesUserRegister): self
    {
        if (!$this->challengesUserRegisters->contains($challengesUserRegister)) {
            $this->challengesUserRegisters[] = $challengesUserRegister;
            $challengesUserRegister->setChallengeRegister($this);
        }

        return $this;
    }

    public function removeChallengesUserRegister(ChallengesUserRegister $challengesUserRegister): self
    {
        if ($this->challengesUserRegisters->removeElement($challengesUserRegister)) {
            // set the owning side to null (unless already changed)
            if ($challengesUserRegister->getChallengeRegister() === $this) {
                $challengesUserRegister->setChallengeRegister(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->imageName,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->imageName,
            ) = unserialize($serialized, array('allowed_classes' => false));
    }

}
