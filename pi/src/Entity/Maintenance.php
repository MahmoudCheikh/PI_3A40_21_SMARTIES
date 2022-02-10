<?php

namespace App\Entity;

use App\Repository\MaintenanceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaintenanceRepository::class)
 */
class Maintenance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Velo::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $idVelo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdVelo(): ?Velo
    {
        return $this->idVelo;
    }

    public function setIdVelo(?Velo $idVelo): self
    {
        $this->idVelo = $idVelo;

        return $this;
    }
}
