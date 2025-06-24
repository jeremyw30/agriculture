<?php

namespace App\Entity;

use App\Repository\MachineActivitiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MachineActivitiesRepository::class)]
class MachineActivities
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
    private ?float $hoursUsed = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mechanicName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $partsReplaced = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $nextMaintenanceDue = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?float $fuelConsumed = null;

    #[ORM\ManyToOne(inversedBy: 'machineActivities')]
    private ?UserMachine $idUserMachine = null;

    /**
     * @var Collection<int, Transaction>
     */
    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'idMachineActivity')]
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

    public function getHoursUsed(): ?float
    {
        return $this->hoursUsed;
    }

    public function setHoursUsed(float $hoursUsed): static
    {
        $this->hoursUsed = $hoursUsed;

        return $this;
    }

    public function getMechanicName(): ?string
    {
        return $this->mechanicName;
    }

    public function setMechanicName(?string $mechanicName): static
    {
        $this->mechanicName = $mechanicName;

        return $this;
    }

    public function getPartsReplaced(): ?string
    {
        return $this->partsReplaced;
    }

    public function setPartsReplaced(?string $partsReplaced): static
    {
        $this->partsReplaced = $partsReplaced;

        return $this;
    }

    public function getNextMaintenanceDue(): ?\DateTimeImmutable
    {
        return $this->nextMaintenanceDue;
    }

    public function setNextMaintenanceDue(?\DateTimeImmutable $nextMaintenanceDue): static
    {
        $this->nextMaintenanceDue = $nextMaintenanceDue;

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

    public function getFuelConsumed(): ?float
    {
        return $this->fuelConsumed;
    }

    public function setFuelConsumed(float $fuelConsumed): static
    {
        $this->fuelConsumed = $fuelConsumed;

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
            $transaction->setIdMachineActivity($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getIdMachineActivity() === $this) {
                $transaction->setIdMachineActivity(null);
            }
        }

        return $this;
    }
}
