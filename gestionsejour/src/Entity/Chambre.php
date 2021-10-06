<?php

namespace App\Entity;

use App\Repository\ChambreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChambreRepository::class)
 */
class Chambre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nochambre;

    /**
     * @ORM\Column(type="integer")
     */
    private $nolit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNochambre(): ?int
    {
        return $this->nochambre;
    }

    public function setNochambre(int $nochambre): self
    {
        $this->nochambre = $nochambre;

        return $this;
    }

    public function getNolit(): ?int
    {
        return $this->nolit;
    }

    public function setNolit(int $nolit): self
    {
        $this->nolit = $nolit;

        return $this;
    }
}
