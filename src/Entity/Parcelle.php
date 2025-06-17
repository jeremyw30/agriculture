<?php

namespace App\Entity;

use App\Repository\ParcelleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParcelleRepository::class)]
class Parcelle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $surface_hectare = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurfaceHectare(): ?float
    {
        return $this->surface_hectare;
    }

    public function setSurfaceHectare(float $surface_hectare): static
    {
        $this->surface_hectare = $surface_hectare;

        return $this;
    }
}
