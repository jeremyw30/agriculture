<?php

namespace App\Entity;

use App\Repository\MeteoDataRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeteoDataRepository::class)]
#[ORM\Table(name: 'meteo_data')]
class MeteoData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: 'float')]
    private ?float $temperature = null;

    #[ORM\Column(type: 'float')]
    private ?float $feels_like = null;

    #[ORM\Column(type: 'float')]
    private ?float $humidity = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $wind_speed = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $wind_direction = null;

    #[ORM\Column(type: 'float')]
    private ?float $pressure = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $precipitation_type = null;

    #[ORM\Column(type: 'string')]
    private ?string $weather = null;

    #[ORM\Column(type: 'string')]
    private ?string $summary = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $cloud_cover = null;

    #[ORM\Column(length: 255)]
    private ?string $zone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): static
    {
        $this->temperature = $temperature;
        return $this;
    }

    public function getFeelsLike(): ?float
    {
        return $this->feels_like;
    }

    public function setFeelsLike(float $feels_like): static
    {
        $this->feels_like = $feels_like;
        return $this;
    }

    public function getHumidity(): ?float
    {
        return $this->humidity;
    }

    public function setHumidity(float $humidity): static
    {
        $this->humidity = $humidity;
        return $this;
    }

    public function getWindSpeed(): ?float
    {
        return $this->wind_speed;
    }

    public function setWindSpeed(?float $wind_speed): static
    {
        $this->wind_speed = $wind_speed;
        return $this;
    }

    public function getWindDirection(): ?string
    {
        return $this->wind_direction;
    }

    public function setWindDirection(?string $wind_direction): static
    {
        $this->wind_direction = $wind_direction;
        return $this;
    }

    public function getPressure(): ?float
    {
        return $this->pressure;
    }

    public function setPressure(float $pressure): static
    {
        $this->pressure = $pressure;
        return $this;
    }

    public function getPrecipitationType(): ?string
    {
        return $this->precipitation_type;
    }

    public function setPrecipitationType(?string $precipitation_type): static
    {
        $this->precipitation_type = $precipitation_type;
        return $this;
    }

    public function getWeather(): ?string
    {
        return $this->weather;
    }

    public function setWeather(string $weather): static
    {
        $this->weather = $weather;
        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): static
    {
        $this->summary = $summary;
        return $this;
    }

    public function getCloudCover(): ?int
    {
        return $this->cloud_cover;
    }

    public function setCloudCover(?int $cloud_cover): static
    {
        $this->cloud_cover = $cloud_cover;
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
}