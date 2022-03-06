<?php

namespace App\Entity;

use App\Repository\FavorisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FavorisRepository::class)
 */
class Favoris
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="favoris")
     */
    private $IdProduit;

    /**
     * @ORM\OneToMany(targetEntity=Users::class, mappedBy="favoris")
     */
    private $IdUser;

    public function __construct()
    {
        $this->IdUser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProduit(): ?Produit
    {
        return $this->IdProduit;
    }

    public function setIdProduit(?Produit $IdProduit): self
    {
        $this->IdProduit = $IdProduit;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getIdUser(): Collection
    {
        return $this->IdUser;
    }

    public function addIdUser(Users $idUser): self
    {
        if (!$this->IdUser->contains($idUser)) {
            $this->IdUser[] = $idUser;
            $idUser->setFavoris($this);
        }

        return $this;
    }

    public function removeIdUser(Users $idUser): self
    {
        if ($this->IdUser->removeElement($idUser)) {
            // set the owning side to null (unless already changed)
            if ($idUser->getFavoris() === $this) {
                $idUser->setFavoris(null);
            }
        }

        return $this;
    }
}
