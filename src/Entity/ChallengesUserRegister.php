<?php

namespace App\Entity;

use App\Repository\ChallengesUserRegisterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChallengesUserRegisterRepository::class)
 */
class ChallengesUserRegister
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="challengesUserRegister")
     */
    private $userRegister;

    /**
     * @ORM\ManyToOne(targetEntity=Challenges::class, inversedBy="challengesUserRegisters")
     */
    private $challengeRegister;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserRegister(): ?User
    {
        return $this->userRegister;
    }

    public function setUserRegister(?User $userRegister): self
    {
        $this->userRegister = $userRegister;

        return $this;
    }

    public function getChallengeRegister(): ?Challenges
    {
        return $this->challengeRegister;
    }

    public function setChallengeRegister(?Challenges $challengeRegister): self
    {
        $this->challengeRegister = $challengeRegister;

        return $this;
    }
}
