<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $transactionType = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    private ?ParcelleActivities $idParcelleActivity = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    private ?BatimentActivities $idBatimentActivities = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    private ?MachineActivities $idMachineActivity = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    private ?AnimalActivities $idAnimalActivity = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(name: 'id_hotel_vente', referencedColumnName: 'Id_hotel_ventes', nullable: true)]
    private ?HotelVentes $idHotelVente = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $idUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransactionType(): ?string
    {
        return $this->transactionType;
    }

    public function setTransactionType(string $transactionType): static
    {
        $this->transactionType = $transactionType;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    public function getIdParcelleActivity(): ?ParcelleActivities
    {
        return $this->idParcelleActivity;
    }

    public function setIdParcelleActivity(?ParcelleActivities $idParcelleActivity): static
    {
        $this->idParcelleActivity = $idParcelleActivity;

        return $this;
    }

    public function getIdBatimentActivities(): ?BatimentActivities
    {
        return $this->idBatimentActivities;
    }

    public function setIdBatimentActivities(?BatimentActivities $idBatimentActivities): static
    {
        $this->idBatimentActivities = $idBatimentActivities;

        return $this;
    }

    public function getIdMachineActivity(): ?MachineActivities
    {
        return $this->idMachineActivity;
    }

    public function setIdMachineActivity(?MachineActivities $idMachineActivity): static
    {
        $this->idMachineActivity = $idMachineActivity;

        return $this;
    }

    public function getIdAnimalActivity(): ?AnimalActivities
    {
        return $this->idAnimalActivity;
    }

    public function setIdAnimalActivity(?AnimalActivities $idAnimalActivity): static
    {
        $this->idAnimalActivity = $idAnimalActivity;

        return $this;
    }

    public function getIdHotelVente(): ?HotelVentes
    {
        return $this->idHotelVente;
    }

    public function setIdHotelVente(?HotelVentes $idHotelVente): static
    {
        $this->idHotelVente = $idHotelVente;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }
}
