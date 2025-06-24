<?php

namespace App\Entity;

use App\Repository\MachineRepository;
use App\Enum\MachineTypeEnum;
use App\Enum\ConditionStatusEnum;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MachineRepository::class)]
#[ORM\Table(name: 'machine')]
class Machine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_machine')]
    private ?int $idMachine = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::STRING, enumType: MachineTypeEnum::class)]
    private ?MachineTypeEnum $type = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $brand = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $model = null;

    #[ORM\Column(nullable: true)]
    private ?int $yearManufactured = null;

    #[ORM\Column(nullable: true)]
    private ?int $powerHp = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2, nullable: true)]
    private ?string $fuelConsumption = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2)]
    private ?string $basePrice = null;

    #[ORM\Column(type: Types::STRING, enumType: ConditionStatusEnum::class)]
    private ConditionStatusEnum $conditionStatus = ConditionStatusEnum::BONNE;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getIdMachine(): ?int
    {
        return $this->idMachine;
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

    public function getType(): ?MachineTypeEnum
    {
        return $this->type;
    }

    public function setType(MachineTypeEnum $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): static
    {
        $this->brand = $brand;
        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): static
    {
        $this->model = $model;
        return $this;
    }

    public function getYearManufactured(): ?int
    {
        return $this->yearManufactured;
    }

    public function setYearManufactured(?int $yearManufactured): static
    {
        $this->yearManufactured = $yearManufactured;
        return $this;
    }

    public function getPowerHp(): ?int
    {
        return $this->powerHp;
    }

    public function setPowerHp(?int $powerHp): static
    {
        $this->powerHp = $powerHp;
        return $this;
    }

    public function getFuelConsumption(): ?string
    {
        return $this->fuelConsumption;
    }

    public function setFuelConsumption(?string $fuelConsumption): static
    {
        $this->fuelConsumption = $fuelConsumption;
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

    public function getConditionStatus(): ConditionStatusEnum
    {
        return $this->conditionStatus;
    }

    public function setConditionStatus(ConditionStatusEnum $conditionStatus): static
    {
        $this->conditionStatus = $conditionStatus;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}