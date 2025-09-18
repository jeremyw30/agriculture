<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;


    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $zone = null;

    #[ORM\Column]
    private ?float $balance = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, UserParcelle>
     */
    #[ORM\OneToMany(targetEntity: UserParcelle::class, mappedBy: 'id_user')]
    private Collection $userParcelles;

    /**
     * @var Collection<int, UserMachine>
     */
    #[ORM\OneToMany(targetEntity: UserMachine::class, mappedBy: 'id_user')]
    private Collection $userMachines;

    /**
     * @var Collection<int, UserBatiment>
     */
    #[ORM\OneToMany(targetEntity: UserBatiment::class, mappedBy: 'idUser')]
    private Collection $userBatiments;

    /**
     * @var Collection<int, UserAnimal>
     */
    #[ORM\OneToMany(targetEntity: UserAnimal::class, mappedBy: 'idUser')]
    private Collection $userAnimals;

    /**
     * @var Collection<int, Transaction>
     */
    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'idUser')]
    private Collection $transactions;

    public function __construct()
    {
        $this->userParcelles = new ArrayCollection();
        $this->userMachines = new ArrayCollection();
        $this->userBatiments = new ArrayCollection();
        $this->userAnimals = new ArrayCollection();
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

   
    

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

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

    public function getZone(): ?string
    {
        return $this->zone;
    }

    public function setZone(string $zone): static
    {
        $this->zone = $zone;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): static
    {
        $this->balance = $balance;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, UserParcelle>
     */
    public function getUserParcelles(): Collection
    {
        return $this->userParcelles;
    }

    public function addUserParcelle(UserParcelle $userParcelle): static
    {
        if (!$this->userParcelles->contains($userParcelle)) {
            $this->userParcelles->add($userParcelle);
            $userParcelle->setIdUser($this);
        }

        return $this;
    }

    public function removeUserParcelle(UserParcelle $userParcelle): static
    {
        if ($this->userParcelles->removeElement($userParcelle)) {
            // set the owning side to null (unless already changed)
            if ($userParcelle->getIdUser() === $this) {
                $userParcelle->setIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserMachine>
     */
    public function getUserMachines(): Collection
    {
        return $this->userMachines;
    }

    public function addUserMachine(UserMachine $userMachine): static
    {
        if (!$this->userMachines->contains($userMachine)) {
            $this->userMachines->add($userMachine);
            $userMachine->setIdUser($this);
        }

        return $this;
    }

    public function removeUserMachine(UserMachine $userMachine): static
    {
        if ($this->userMachines->removeElement($userMachine)) {
            // set the owning side to null (unless already changed)
            if ($userMachine->getIdUser() === $this) {
                $userMachine->setIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserBatiment>
     */
    public function getUserBatiments(): Collection
    {
        return $this->userBatiments;
    }

    public function addUserBatiment(UserBatiment $userBatiment): static
    {
        if (!$this->userBatiments->contains($userBatiment)) {
            $this->userBatiments->add($userBatiment);
            $userBatiment->setIdUser($this);
        }

        return $this;
    }

    public function removeUserBatiment(UserBatiment $userBatiment): static
    {
        if ($this->userBatiments->removeElement($userBatiment)) {
            // set the owning side to null (unless already changed)
            if ($userBatiment->getIdUser() === $this) {
                $userBatiment->setIdUser(null);
            }
        }

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
            $userAnimal->setIdUser($this);
        }

        return $this;
    }

    public function removeUserAnimal(UserAnimal $userAnimal): static
    {
        if ($this->userAnimals->removeElement($userAnimal)) {
            // set the owning side to null (unless already changed)
            if ($userAnimal->getIdUser() === $this) {
                $userAnimal->setIdUser(null);
            }
        }

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
            $transaction->setIdUser($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getIdUser() === $this) {
                $transaction->setIdUser(null);
            }
        }

        return $this;
    }
}
