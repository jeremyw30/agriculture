<?php

namespace App\Entity;

use App\Repository\UserMachineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserMachineRepository::class)]
class UserMachine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $customName = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $acquired_at = null;

    #[ORM\Column]
    private ?float $fuelLevel = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $last_maintenance_at = null;

    #[ORM\Column]
    private ?bool $is_active = null;

    #[ORM\ManyToOne(inversedBy: 'userMachines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $id_user = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'id_machine', referencedColumnName: 'id_machine', nullable: false)]
    private ?Machine $id_machine = null;

    /**
     * @var Collection<int, ParcelleActivities>
     */
    #[ORM\OneToMany(targetEntity: ParcelleActivities::class, mappedBy: 'idUserMachine')]
    private Collection $parcelleActivities;

    /**
     * @var Collection<int, AnimalActivities>
     */
    #[ORM\OneToMany(targetEntity: AnimalActivities::class, mappedBy: 'idUserMachine')]
    private Collection $animalActivities;

    /**
     * @var Collection<int, MachineActivities>
     */
    #[ORM\OneToMany(targetEntity: MachineActivities::class, mappedBy: 'idUserMachine')]
    private Collection $machineActivities;

    public function __construct()
    {
        $this->parcelleActivities = new ArrayCollection();
        $this->animalActivities = new ArrayCollection();
        $this->machineActivities = new ArrayCollection();
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

    public function getAcquiredAt(): ?\DateTimeImmutable
    {
        return $this->acquired_at;
    }

    public function setAcquiredAt(\DateTimeImmutable $acquired_at): static
    {
        $this->acquired_at = $acquired_at;

        return $this;
    }

    public function getFuelLevel(): ?float
    {
        return $this->fuelLevel;
    }

    public function setFuelLevel(float $fuelLevel): static
    {
        $this->fuelLevel = $fuelLevel;

        return $this;
    }

    public function getLastMaintenanceAt(): ?\DateTimeImmutable
    {
        return $this->last_maintenance_at;
    }

    public function setLastMaintenanceAt(?\DateTimeImmutable $last_maintenance_at): static
    {
        $this->last_maintenance_at = $last_maintenance_at;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): static
    {
        $this->is_active = $is_active;

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

    public function getIdMachine(): ?Machine
    {
        return $this->id_machine;
    }

    public function setIdMachine(?Machine $id_machine): static
    {
        $this->id_machine = $id_machine;

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
            $parcelleActivity->setIdUserMachine($this);
        }

        return $this;
    }

    public function removeParcelleActivity(ParcelleActivities $parcelleActivity): static
    {
        if ($this->parcelleActivities->removeElement($parcelleActivity)) {
            // set the owning side to null (unless already changed)
            if ($parcelleActivity->getIdUserMachine() === $this) {
                $parcelleActivity->setIdUserMachine(null);
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
            $animalActivity->setIdUserMachine($this);
        }

        return $this;
    }

    public function removeAnimalActivity(AnimalActivities $animalActivity): static
    {
        if ($this->animalActivities->removeElement($animalActivity)) {
            // set the owning side to null (unless already changed)
            if ($animalActivity->getIdUserMachine() === $this) {
                $animalActivity->setIdUserMachine(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MachineActivities>
     */
    public function getMachineActivities(): Collection
    {
        return $this->machineActivities;
    }

    public function addMachineActivity(MachineActivities $machineActivity): static
    {
        if (!$this->machineActivities->contains($machineActivity)) {
            $this->machineActivities->add($machineActivity);
            $machineActivity->setIdUserMachine($this);
        }

        return $this;
    }

    public function removeMachineActivity(MachineActivities $machineActivity): static
    {
        if ($this->machineActivities->removeElement($machineActivity)) {
            // set the owning side to null (unless already changed)
            if ($machineActivity->getIdUserMachine() === $this) {
                $machineActivity->setIdUserMachine(null);
            }
        }

        return $this;
    }
}
