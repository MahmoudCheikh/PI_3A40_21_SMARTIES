<?php

namespace App\Entity;

use App\Repository\EmplacementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=EmplacementRepository::class)
 */
class Emplacement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="lieu de l'emplacement is required")
     */
    private $lieu;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message="capacité doit etre positive")
     * @Assert\NotBlank(message="nom de la capacité is required")
     */
    private $capacite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }
}
