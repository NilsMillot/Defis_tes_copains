<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 */
class Payment
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
    private $colStripe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColStripe(): ?string
    {
        return $this->colStripe;
    }

    public function setColStripe(string $colStripe): self
    {
        $this->colStripe = $colStripe;

        return $this;
    }
}
