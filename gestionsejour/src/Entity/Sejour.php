<?php

namespace App\Entity;

use App\Repository\SejourRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SejourRepository::class)
 */
class Sejour
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateArrivee;

    /**
     * @ORM\Column(type="float")
     */
    private $heureArrivee;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDepart;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $heureDepart;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class)
     */
    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class)
     */
    private $service;

    /**
     * @ORM\ManyToOne(targetEntity=Chambre::class)
     */
    private $chambre;

    /**
     * @ORM\ManyToOne(targetEntity=Medecin::class, inversedBy="sejour")
     */
    private $medecin;
    
    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDateArrivee(): ?\DateTimeInterface
    {
        return $this->dateArrivee;
    }

    public function setDateArrivee(\DateTimeInterface $dateArrivee): self
    {
        $this->dateArrivee = $dateArrivee;

        return $this;
    }

    public function getHeureArrivee(): ?float
    {
        return $this->heureArrivee;
    }

    public function setHeureArrivee(float $heureArrivee): self
    {
        $this->heureArrivee = $heureArrivee;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(?\DateTimeInterface $dateDepart): self
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getHeureDepart(): ?float
    {
        return $this->heureDepart;
    }

    public function setHeureDepart(?float $heureDepart): self
    {
        $this->heureDepart = $heureDepart;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $Patient): self
    {
        $this->patient = $Patient;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $Service): self
    {
        $this->service = $Service;

        return $this;
    }

    public function getChambre(): ?Chambre
    {
        return $this->chambre;
    }

    public function setChambre(?Chambre $Chambre): self
    {
        $this->chambre = $Chambre;

        return $this;
    }

    public function getMedecin(): ?Medecin
    {
        return $this->medecin;
    }

    public function setMedecin(?Medecin $medecin): self
    {
        $this->medecin = $medecin;

        return $this;
    }
}