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
     * @ORM\ManyToOne(targetEntity=Users::class)
     */
    private $relation;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $idProduit;

    /**
     * @ORM\Column(type="date")
     */
    private $DateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $DateFin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\OneToOne(targetEntity=Reclamation::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $reclamation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRelation(): ?Users
    {
        return $this->relation;
    }

    public function setRelation(?Users $relation): self
    {
        $this->relation = $relation;

        return $this;
    }

    public function getIdProduit(): ?Produit
    {
        return $this->idProduit;
    }

    public function setIdProduit(?Produit $idProduit): self
    {
        $this->idProduit = $idProduit;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(\DateTimeInterface $DateDebut): self
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(\DateTimeInterface $DateFin): self
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getReclamation(): ?reclamation
    {
        return $this->reclamation;
    }

    public function setReclamation(reclamation $reclamation): self
    {
        $this->reclamation = $reclamation;

        return $this;
    }
}
