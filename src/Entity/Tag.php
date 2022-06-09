<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
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
     * @ORM\ManyToMany(targetEntity=Challenges::class, mappedBy="tags")
     */
    private $challenge;

    public function __construct()
    {
        $this->challenge = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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

    /**
     * @return Collection|Challenges
     */

    public function getChallenges(): Collection
    {
        return $this->challenges;
    }
    public function addChallenges(Challenges $challenge): self
    {
        if (!$this->challenges->contains($challenge)){
            $this->challenges[] = $challenge;
            $challenge->addTag($this);
        }
        return $this;
    }

    public function removeChallenges(Challenges $challenge): self
    {
        if ($this->challenges->removeElement($challenge)) {
            $challenge->removeTag($this);
        }
        return $this;
    }
}
