<?php

namespace App\Entity;

use App\Repository\UserBatimentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserBatimentRepository::class)]
class UserBatiment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $customName = null;

    #[ORM\Column(nullable: true)]
    private ?int $currentOccupancy = null;

    #[ORM\Column(nullable: true)]
    private ?float $storedQuantity = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\ManyToOne(inversedBy: 'userBatiments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $idUser = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'id_batiment', referencedColumnName: 'id_batiment', nullable: false)]
    private ?Batiment $idBatiment = null;

    /**
     * @var Collection<int, UserAnimal>
     */
    #[ORM\OneToMany(targetEntity: UserAnimal::class, mappedBy: 'idUserBatiment')]
    private Collection $userAnimals;

    /**
     * @var Collection<int, AnimalActivities>
     */
    #[ORM\OneToMany(targetEntity: AnimalActivities::class, mappedBy: 'idUserBatiment')]
    private Collection $animalActivities;

    /**
     * @var Collection<int, BatimentActivities>
     */
    #[ORM\OneToMany(targetEntity: BatimentActivities::class, mappedBy: 'idUserBatiment')]
    private Collection $batimentActivities;

    public function __construct()
    {
        $this->userAnimals = new ArrayCollection();
        $this->animalActivities = new ArrayCollection();
        $this->batimentActivities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomName(): ?string
    {
        return $this->customName;
    }

    public function setCustomName(string $customName): static
    {
        $this->customName = $customName;

        return $this;
    }

    public function getCurrentOccupancy(): ?int
    {
        return $this->currentOccupancy;
    }

    public function setCurrentOccupancy(?int $currentOccupancy): static
    {
        $this->currentOccupancy = $currentOccupancy;

        return $this;
    }

    public function getStoredQuantity(): ?float
    {
        return $this->storedQuantity;
    }

    public function setStoredQuantity(?float $storedQuantity): static
    {
        $this->storedQuantity = $storedQuantity;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

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

    public function getIdBatiment(): ?Batiment
    {
        return $this->idBatiment;
    }

    public function setIdBatiment(?Batiment $idBatiment): static
    {
        $this->idBatiment = $idBatiment;

        return $this;
    }

    /**
     * @return Collection<int, UserAnimal>
     */
    public function getUserAnimals(): Collection
    {
        return $this->userAnimals;
    }

    public function addUserAnimal(UserAnimal $userAnimal): static
    {
        if (!$this->userAnimals->contains($userAnimal)) {
            $this->userAnimals->add($userAnimal);
            $userAnimal->setIdUserBatiment($this);
        }

        return $this;
    }

    public function removeUserAnimal(UserAnimal $userAnimal): static
    {
        if ($this->userAnimals->removeElement($userAnimal)) {
            // set the owning side to null (unless already changed)
            if ($userAnimal->getIdUserBatiment() === $this) {
                $userAnimal->setIdUserBatiment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AnimalActivities>
     */
    public function getAnimalActivities(): Collection
    {
        return $this->animalActivities;
    }

    public function addAnimalActivity(AnimalActivities $animalActivity): static
    {
        if (!$this->animalActivities->contains($animalActivity)) {
            $this->animalActivities->add($animalActivity);
            $animalActivity->setIdUserBatiment($this);
        }

        return $this;
    }

    public function removeAnimalActivity(AnimalActivities $animalActivity): static
    {
        if ($this->animalActivities->removeElement($animalActivity)) {
            // set the owning side to null (unless already changed)
            if ($animalActivity->getIdUserBatiment() === $this) {
                $animalActivity->setIdUserBatiment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BatimentActivities>
     */
    public function getBatimentActivities(): Collection
    {
        return $this->batimentActivities;
    }

    public function addBatimentActivity(BatimentActivities $batimentActivity): static
    {
        if (!$this->batimentActivities->contains($batimentActivity)) {
            $this->batimentActivities->add($batimentActivity);
            $batimentActivity->setIdUserBatiment($this);
        }

        return $this;
    }

    public function removeBatimentActivity(BatimentActivities $batimentActivity): static
    {
        if ($this->batimentActivities->removeElement($batimentActivity)) {
            // set the owning side to null (unless already changed)
            if ($batimentActivity->getIdUserBatiment() === $this) {
                $batimentActivity->setIdUserBatiment(null);
            }
        }

        return $this;
    }
}
