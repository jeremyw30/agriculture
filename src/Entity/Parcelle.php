<?php

namespace App\Entity;

use App\Repository\ParcelleRepository;
use App\Enum\TypeSolEnum;
use App\Enum\FertilityLevelEnum;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParcelleRepository::class)]
#[ORM\Table(name: 'parcelles')]
class Parcelle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $surfaceHectares = null;

    #[ORM\Column(type: Types::STRING, enumType: TypeSolEnum::class)]
    private ?TypeSolEnum $typeSol = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?int $location = null;

    #[ORM\Column(type: Types::STRING, enumType: FertilityLevelEnum::class)]
    private FertilityLevelEnum $fertilityLevel = FertilityLevelEnum::MOYENNE;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 2)]
    private ?string $basePrice = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxAnimalsCapacity = 0;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

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

    public function getSurfaceHectares(): ?string
    {
        return $this->surfaceHectares;
    }

    public function setSurfaceHectares(string $surfaceHectares): static
    {
        $this->surfaceHectares = $surfaceHectares;
        return $this;
    }

    public function getTypeSol(): ?TypeSolEnum
    {
        return $this->typeSol;
    }

    public function setTypeSol(TypeSolEnum $typeSol): static
    {
        $this->typeSol = $typeSol;
        return $this;
    }

    public function getLocation(): ?int
    {
        return $this->location;
    }

    public function setLocation(?int $location): static
    {
        $this->location = $location;
        return $this;
    }

    public function getFertilityLevel(): FertilityLevelEnum
    {
        return $this->fertilityLevel;
    }

    public function setFertilityLevel(FertilityLevelEnum $fertilityLevel): static
    {
        $this->fertilityLevel = $fertilityLevel;
        return $this;
    }

    public function getBasePrice(): ?string
    {
        return $this->basePrice;
    }

    public function setBasePrice(string $basePrice): static
    {
        $this->basePrice = $basePrice;
        return $this;
    }

    public function getMaxAnimalsCapacity(): ?int
    {
        return $this->maxAnimalsCapacity;
    }

    public function setMaxAnimalsCapacity(?int $maxAnimalsCapacity): static
    {
        $this->maxAnimalsCapacity = $maxAnimalsCapacity;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}