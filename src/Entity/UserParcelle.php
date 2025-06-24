<?php

namespace App\Entity;

use App\Repository\UserParcelleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserParcelleRepository::class)]
class UserParcelle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $customName = null;

    #[ORM\Column(length: 255)]
    private ?string $currentCrop = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $expected_harvest_at = null;

    #[ORM\ManyToOne(inversedBy: 'userParcelles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $id_user = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Parcelle $id_parcelle = null;

    /**
     * @var Collection<int, UserAnimal>
     */
    #[ORM\OneToMany(targetEntity: UserAnimal::class, mappedBy: 'idUserParcelle')]
    private Collection $userAnimals;

    /**
     * @var Collection<int, ParcelleActivities>
     */
    #[ORM\OneToMany(targetEntity: ParcelleActivities::class, mappedBy: 'idUserParcelle')]
    private Collection $parcelleActivities;

    /**
     * @var Collection<int, AnimalActivities>
     */
    #[ORM\OneToMany(targetEntity: AnimalActivities::class, mappedBy: 'idUserParcelle')]
    private Collection $animalActivities;

    public function __construct()
    {
        $this->userAnimals = new ArrayCollection();
        $this->parcelleActivities = new ArrayCollection();
        $this->animalActivities = new ArrayCollection();
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

    public function getCurrentCrop(): ?string
    {
        return $this->currentCrop;
    }

    public function setCurrentCrop(string $currentCrop): static
    {
        $this->currentCrop = $currentCrop;

        return $this;
    }

    public function getExpectedHarvestAt(): ?\DateTimeImmutable
    {
        return $this->expected_harvest_at;
    }

    public function setExpectedHarvestAt(?\DateTimeImmutable $expected_harvest_at): static
    {
        $this->expected_harvest_at = $expected_harvest_at;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdParcelle(): ?Parcelle
    {
        return $this->id_parcelle;
    }

    public function setIdParcelle(?Parcelle $id_parcelle): static
    {
        $this->id_parcelle = $id_parcelle;

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
            $userAnimal->setIdUserParcelle($this);
        }

        return $this;
    }

    public function removeUserAnimal(UserAnimal $userAnimal): static
    {
        if ($this->userAnimals->removeElement($userAnimal)) {
            // set the owning side to null (unless already changed)
            if ($userAnimal->getIdUserParcelle() === $this) {
                $userAnimal->setIdUserParcelle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ParcelleActivities>
     */
    public function getParcelleActivities(): Collection
    {
        return $this->parcelleActivities;
    }

    public function addParcelleActivity(ParcelleActivities $parcelleActivity): static
    {
        if (!$this->parcelleActivities->contains($parcelleActivity)) {
            $this->parcelleActivities->add($parcelleActivity);
            $parcelleActivity->setIdUserParcelle($this);
        }

        return $this;
    }

    public function removeParcelleActivity(ParcelleActivities $parcelleActivity): static
    {
        if ($this->parcelleActivities->removeElement($parcelleActivity)) {
            // set the owning side to null (unless already changed)
            if ($parcelleActivity->getIdUserParcelle() === $this) {
                $parcelleActivity->setIdUserParcelle(null);
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
            $animalActivity->setIdUserParcelle($this);
        }

        return $this;
    }

    public function removeAnimalActivity(AnimalActivities $animalActivity): static
    {
        if ($this->animalActivities->removeElement($animalActivity)) {
            // set the owning side to null (unless already changed)
            if ($animalActivity->getIdUserParcelle() === $this) {
                $animalActivity->setIdUserParcelle(null);
            }
        }

        return $this;
    }


}
