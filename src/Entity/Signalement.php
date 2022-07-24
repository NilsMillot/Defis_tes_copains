<?php

namespace App\Entity;

use App\Repository\SignalementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SignalementRepository::class)
 */
class Signalement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="signalements")
     */
    private $id_user_signalement;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="signalements")
     */
    private $id_post;

    /**
     * @ORM\ManyToOne(targetEntity=Remark::class, inversedBy="signalements")
     */
    private $id_remark;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUserSignalement(): ?User
    {
        return $this->id_user_signalement;
    }

    public function setIdUserSignalement(?User $id_user_signalement): self
    {
        $this->id_user_signalement = $id_user_signalement;

        return $this;
    }

    public function getIdPost(): ?Post
    {
        return $this->id_post;
    }

    public function setIdPost(?Post $id_post): self
    {
        $this->id_post = $id_post;

        return $this;
    }

    public function getIdRemark(): ?Remark
    {
        return $this->id_remark;
    }

    public function setIdRemark(?Remark $id_remark): self
    {
        $this->id_remark = $id_remark;

        return $this;
    }
}
