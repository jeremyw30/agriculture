<?php

namespace App\Entity;

use App\Repository\ParcelleActivitiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParcelleActivitiesRepository::class)]
class ParcelleActivities
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $activityType = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $cost = null;

    #[ORM\Column]
    private ?float $revenue = null;

    #[ORM\Column(length: 255)]
    private ?string $cropType = null;

    #[ORM\Column]
    private ?float $quantityPlanted = null;

    #[ORM\Column]
    private ?float $quantityHarvested = null;

    #[ORM\ManyToOne(inversedBy: 'parcelleActivities')]
    private ?UserMachine $idUserMachine = null;

    #[ORM\ManyToOne(inversedBy: 'parcelleActivities')]
    private ?UserParcelle $idUserParcelle = null;

    /**
     * @var Collection<int, Transaction>
     */
    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'idParcelleActivity')]
    private Collection $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActivityType(): ?string
    {
        return $this->activityType;
    }

    public function setActivityType(string $activityType): static
    {
        $this->activityType = $activityType;

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

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(float $cost): static
    {
        $this->cost = $cost;

        return $this;
    }

    public function getRevenue(): ?float
    {
        return $this->revenue;
    }

    public function setRevenue(float $revenue): static
    {
        $this->revenue = $revenue;

        return $this;
    }

    public function getCropType(): ?string
    {
        return $this->cropType;
    }

    public function setCropType(string $cropType): static
    {
        $this->cropType = $cropType;

        return $this;
    }

    public function getQuantityPlanted(): ?float
    {
        return $this->quantityPlanted;
    }

    public function setQuantityPlanted(float $quantityPlanted): static
    {
        $this->quantityPlanted = $quantityPlanted;

        return $this;
    }

    public function getQuantityHarvested(): ?float
    {
        return $this->quantityHarvested;
    }

    public function setQuantityHarvested(float $quantityHarvested): static
    {
        $this->quantityHarvested = $quantityHarvested;

        return $this;
    }

    public function getIdUserMachine(): ?UserMachine
    {
        return $this->idUserMachine;
    }

    public function setIdUserMachine(?UserMachine $idUserMachine): static
    {
        $this->idUserMachine = $idUserMachine;

        return $this;
    }

    public function getIdUserParcelle(): ?UserParcelle
    {
        return $this->idUserParcelle;
    }

    public function setIdUserParcelle(?UserParcelle $idUserParcelle): static
    {
        $this->idUserParcelle = $idUserParcelle;

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): static
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->setIdParcelleActivity($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getIdParcelleActivity() === $this) {
                $transaction->setIdParcelleActivity(null);
            }
        }

        return $this;
    }
}
