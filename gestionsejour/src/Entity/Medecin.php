<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MedecinRepository::class)
 */
class Medecin
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="medecins")
     */
    private $Service;

    /**
     * @ORM\OneToMany(targetEntity=Sejour::class, mappedBy="medecin")
     */
    private $Sejour;

    public function __construct()
    {
        $this->Sejour = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->Service;
    }

    public function setService(?Service $Service): self
    {
        $this->Service = $Service;

        return $this;
    }

    /**
     * @return Collection|Sejour[]
     */
    public function getSejour(): Collection
    {
        return $this->Sejour;
    }

    public function addSejour(Sejour $Sejour): self
    {
        if (!$this->Sejour->contains($Sejour)) {
            $this->Sejour[] = $Sejour;
            $Sejour->setMedecin($this);
        }

        return $this;
    }

    public function removeSejour(Sejour $Sejour): self
    {
        if ($this->Sejour->removeElement($Sejour)) {
            // set the owning side to null (unless already changed)
            if ($Sejour->getMedecin() === $this) {
                $Sejour->setMedecin(null);
            }
        }

        return $this;
    }

    public function getInfo(): ?string
    {
        return $this->nom.'-'. $this->prenom;
    }
}