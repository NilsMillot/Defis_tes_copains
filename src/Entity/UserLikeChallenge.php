<?php

namespace App\Entity;

use App\Repository\UserLikeChallengeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserLikeChallengeRepository::class)
 */
class UserLikeChallenge
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userLikeChallenges")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userWhoLikedChallenge;

    /**
     * @ORM\ManyToOne(targetEntity=Challenges::class, inversedBy="userLikeChallenges")
     * @ORM\JoinColumn(nullable=false)
     */
    private $challengesLiked;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserWhoLikedChallenge(): ?User
    {
        return $this->userWhoLikedChallenge;
    }

    public function setUserWhoLikedChallenge(?User $userWhoLikedChallenge): self
    {
        $this->userWhoLikedChallenge = $userWhoLikedChallenge;

        return $this;
    }

    public function getChallengesLiked(): ?Challenges
    {
        return $this->challengesLiked;
    }

    public function setChallengesLiked(?Challenges $challengesLiked): self
    {
        $this->challengesLiked = $challengesLiked;

        return $this;
    }
}
