<?php

namespace App\Entity;

use App\Repository\UserAnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserAnimalRepository::class)]
class UserAnimal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isName = null;

    #[ORM\Column(length: 255)]
    private ?string $customName = null;

    #[ORM\Column(length: 255)]
    private ?string $currentLocationType = null;

    #[ORM\ManyToOne(inversedBy: 'userAnimals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $idUser = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'id_animal', referencedColumnName: 'id_animal', nullable: false)]
    private ?Animal $idAnimal = null;

    #[ORM\ManyToOne(inversedBy: 'userAnimals')]
    private ?UserBatiment $idUserBatiment = null;

    #[ORM\ManyToOne(inversedBy: 'userAnimals')]
    private ?UserParcelle $idUserParcelle = null;

    /**
     * @var Collection<int, AnimalActivities>
     */
    #[ORM\OneToMany(targetEntity: AnimalActivities::class, mappedBy: 'idUserAnimal')]
    private Collection $animalActivities;

    public function __construct()
    {
        $this->animalActivities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isName(): ?bool
    {
        return $this->isName;
    }

    public function setIsName(bool $isName): static
    {
        $this->isName = $isName;

        return $this;
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

    public function getCurrentLocationType(): ?string
    {
        return $this->currentLocationType;
    }

    public function setCurrentLocationType(string $currentLocationType): static
    {
        $this->currentLocationType = $currentLocationType;

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

    public function getIdAnimal(): ?Animal
    {
        return $this->idAnimal;
    }

    public function setIdAnimal(?Animal $idAnimal): static
    {
        $this->idAnimal = $idAnimal;

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
            $animalActivity->setIdUserAnimal($this);
        }

        return $this;
    }

    public function removeAnimalActivity(AnimalActivities $animalActivity): static
    {
        if ($this->animalActivities->removeElement($animalActivity)) {
            // set the owning side to null (unless already changed)
            if ($animalActivity->getIdUserAnimal() === $this) {
                $animalActivity->setIdUserAnimal(null);
            }
        }

        return $this;
    }
}
