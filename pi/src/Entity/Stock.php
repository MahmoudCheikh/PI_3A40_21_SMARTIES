<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=StockRepository::class)
 */
class Stock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le champs de libelle de stock est requis")
     */
    private $libelle;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="le champs de prix est requis")
     * @Assert\Positive(message="prix du stock doit etre positive")
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="le champs quantite de stock est requis")
     * @Assert\Positive(message="quantite du stock doit etre positive")
     */
    private $quantite;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le champs de disponibilité est requis")
     * @Assert\Choice(choices = {"Disponible", "Non Disponible"}, message = "Choisire disponibilite soit 'Disponible' soit 'Non Disponible'." )
     */
    private $disponibilite;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="Stock")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idProduit;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getDisponibilite(): ?string
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(string $disponibilite): self
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }
    public function getIdProduit(): ?Produit
    {
        return $this->idProduit;
    }

    public function setIdProduit(?Produit $produit): self
    {
        $this->idProduit = $produit;

        return $this;
    }

    public function getEmplacement(): ?Emplacement
    {
        return $this->emplacement;
    }

    public function setEmplacement(Emplacement $emplacement): self
    {
        // set the owning side of the relation if necessary
        if ($emplacement->getStock() !== $this) {
            $emplacement->setStock($this);
        }

        $this->emplacement = $emplacement;

        return $this;
    }
    public function __toString() {
        return $this->libelle;
    }

}
