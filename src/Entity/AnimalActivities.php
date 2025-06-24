<?php

namespace App\Entity;

use App\Repository\AnimalActivitiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalActivitiesRepository::class)]
class AnimalActivities
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $cost = null;

    #[ORM\Column]
    private ?float $revenue = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $veterinarianName = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'animalActivities')]
    private ?UserMachine $idUserMachine = null;

    #[ORM\ManyToOne(inversedBy: 'animalActivities')]
    private ?UserBatiment $idUserBatiment = null;

    #[ORM\ManyToOne(inversedBy: 'animalActivities')]
    private ?UserParcelle $idUserParcelle = null;

    #[ORM\ManyToOne(inversedBy: 'animalActivities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserAnimal $idUserAnimal = null;

    /**
     * @var Collection<int, Transaction>
     */
    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'idAnimalActivity')]
    private Collection $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getVeterinarianName(): ?string
    {
        return $this->veterinarianName;
    }

    public function setVeterinarianName(?string $veterinarianName): static
    {
        $this->veterinarianName = $veterinarianName;

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

    public function getIdUserMachine(): ?UserMachine
    {
        return $this->idUserMachine;
    }

    public function setIdUserMachine(?UserMachine $idUserMachine): static
    {
        $this->idUserMachine = $idUserMachine;

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

    public function getIdUserParcelle(): ?UserParcelle
    {
        return $this->idUserParcelle;
    }

    public function setIdUserParcelle(?UserParcelle $idUserParcelle): static
    {
        $this->idUserParcelle = $idUserParcelle;

        return $this;
    }

    public function getIdUserAnimal(): ?UserAnimal
    {
        return $this->idUserAnimal;
    }

    public function setIdUserAnimal(?UserAnimal $idUserAnimal): static
    {
        $this->idUserAnimal = $idUserAnimal;

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
            $transaction->setIdAnimalActivity($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getIdAnimalActivity() === $this) {
                $transaction->setIdAnimalActivity(null);
            }
        }

        return $this;
    }
}
