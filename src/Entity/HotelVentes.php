<?php

namespace App\Entity;

use App\Repository\HotelVentesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HotelVentesRepository::class)]
#[ORM\Table(name: 'hotel_ventes')]
class HotelVentes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'Id_hotel_ventes')]
    private ?int $idHotelVentes = null;

    #[ORM\Column(length: 50)]
    private ?string $itemType = null;

    #[ORM\Column]
    private ?int $itemId = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2)]
    private ?string $askingPrice = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2, nullable: true)]
    private ?string $finalPrice = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $title = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private ?bool $isSold = false;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private ?bool $isActive = true;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $soldAt = null;

    /**
     * @var Collection<int, Transaction>
     */
    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'idHotelVente')]
    private Collection $transactions;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->isSold = false;
        $this->isActive = true;
        $this->transactions = new ArrayCollection();
    }

    public function getIdHotelVentes(): ?int
    {
        return $this->idHotelVentes;
    }

    public function getItemType(): ?string
    {
        return $this->itemType;
    }

    public function setItemType(string $itemType): static
    {
        $this->itemType = $itemType;
        return $this;
    }

    public function getItemId(): ?int
    {
        return $this->itemId;
    }

    public function setItemId(int $itemId): static
    {
        $this->itemId = $itemId;
        return $this;
    }

    public function getAskingPrice(): ?string
    {
        return $this->askingPrice;
    }

    public function setAskingPrice(string $askingPrice): static
    {
        $this->askingPrice = $askingPrice;
        return $this;
    }

    public function getFinalPrice(): ?string
    {
        return $this->finalPrice;
    }

    public function setFinalPrice(?string $finalPrice): static
    {
        $this->finalPrice = $finalPrice;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function isIsSold(): ?bool
    {
        return $this->isSold;
    }

    public function setIsSold(?bool $isSold): static
    {
        $this->isSold = $isSold;
        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): static
    {
        $this->isActive = $isActive;
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

    public function getSoldAt(): ?\DateTimeImmutable
    {
        return $this->soldAt;
    }

    public function setSoldAt(?\DateTimeImmutable $soldAt): static
    {
        $this->soldAt = $soldAt;
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
            $transaction->setIdHotelVente($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getIdHotelVente() === $this) {
                $transaction->setIdHotelVente(null);
            }
        }

        return $this;
    }
}