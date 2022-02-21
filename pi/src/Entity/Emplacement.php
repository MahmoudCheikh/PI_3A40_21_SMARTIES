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
     * @Assert\NotBlank(message="l'emplacement est requis")
     */
    private $lieu;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message="capacité doit etre positive")
     * @Assert\LessThanOrEqual(
     *     message="trés grande quantité !",
     *     value=10)
     * @Assert\GreaterThanOrEqual(
     *     message="trés peut !",
     *     value=10000)
     * @Assert\NotBlank(message="la capacité du site est requis")
     */
    private $capacite;

    /**
     * @ORM\ManyToOne(targetEntity=Stock::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $Stock;


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

    public function getIdProduit(): ?Produit
    {
        return $this->idProduit;
    }

    public function setIdProduit(?Produit $idProduit): self
    {
        $this->idProduit = $idProduit;

        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->Stock;
    }

    public function setStock(Stock $Stock): self
    {
        $this->Stock = $Stock;

        return $this;
    }



}
