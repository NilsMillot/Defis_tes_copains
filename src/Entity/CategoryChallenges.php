<?php

namespace App\Entity;

use App\Repository\CategoryChallengesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryChallengesRepository::class)
 */
class CategoryChallenges
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Challenges::class, inversedBy="categoryChallenges")
     */
    private $idChallenge;

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

    public function getIdChallenge(): ?Challenges
    {
        return $this->idChallenge;
    }

    public function setIdChallenge(?Challenges $idChallenge): self
    {
        $this->idChallenge = $idChallenge;

        return $this;
    }
}
