<?php

namespace App\Entity;

use App\Repository\BatimentActivitiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BatimentActivitiesRepository::class)]
class BatimentActivities
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

    #[ORM\Column(nullable: true)]
    private ?int $animalCount = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contractorName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $materialsUsed = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'batimentActivities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserBatiment $idUserBatiment = null;

    /**
     * @var Collection<int, Transaction>
     */
    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'idBatimentActivities')]
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

    public function getAnimalCount(): ?int
    {
        return $this->animalCount;
    }

    public function setAnimalCount(?int $animalCount): static
    {
        $this->animalCount = $animalCount;

        return $this;
    }

    public function getContractorName(): ?string
    {
        return $this->contractorName;
    }

    public function setContractorName(?string $contractorName): static
    {
        $this->contractorName = $contractorName;

        return $this;
    }

    public function getMaterialsUsed(): ?string
    {
        return $this->materialsUsed;
    }

    public function setMaterialsUsed(?string $materialsUsed): static
    {
        $this->materialsUsed = $materialsUsed;

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

    public function getIdUserBatiment(): ?UserBatiment
    {
        return $this->idUserBatiment;
    }

    public function setIdUserBatiment(?UserBatiment $idUserBatiment): static
    {
        $this->idUserBatiment = $idUserBatiment;

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
            $transaction->setIdBatimentActivities($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getIdBatimentActivities() === $this) {
                $transaction->setIdBatimentActivities(null);
            }
        }

        return $this;
    }
}
