namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MeteoDataRepository")
 * @ORM\Table(name="meteo_data")
 */
class MeteoData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="float")
     */
    private $temperature;

    /**
     * @ORM\Column(type="float")
     */
    private $feels_like;

    /**
     * @ORM\Column(type="float")
     */
    private $humidity;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $wind_speed;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $wind_direction;

    /**
     * @ORM\Column(type="float")
     */
    private $pressure;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $precipitation_type;

    /**
     * @ORM\Column(type="string")
     */
    private $weather;

    /**
     * @ORM\Column(type="string")
     */
    private $summary;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cloud_cover;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): self
    {
        $this->temperature = $temperature;
        return $this;
    }

    public function getFeelsLike(): ?float
    {
        return $this->feels_like;
    }

    public function setFeelsLike(float $feels_like): self
    {
        $this->feels_like = $feels_like;
        return $this;
    }

    public function getHumidity(): ?float
    {
        return $this->humidity;
    }

    public function setHumidity(float $humidity): self
    {
        $this->humidity = $humidity;
        return $this;
    }

    public function getWindSpeed(): ?float
    {
        return $this->wind_speed;
    }

    public function setWindSpeed(?float $wind_speed): self
    {
        $this->wind_speed = $wind_speed;
        return $this;
    }

    public function getWindDirection(): ?string
    {
        return $this->wind_direction;
    }

    public function setWindDirection(?string $wind_direction): self
    {
        $this->wind_direction = $wind_direction;
        return $this;
    }

    public function getPressure(): ?float
    {
        return $this->pressure;
    }

    public function setPressure(float $pressure): self
    {
        $this->pressure = $pressure;
        return $this;
    }

    public function getPrecipitationType(): ?string
    {
        return $this->precipitation_type;
    }

    public function setPrecipitationType(?string $precipitation_type): self
    {
        $this->precipitation_type = $precipitation_type;
        return $this;
    }

    public function getWeather(): ?string
    {
        return $this->weather;
    }

    public function setWeather(string $weather): self
    {
        $this->weather = $weather;
        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;
        return $this;
    }

    public function getCloudCover(): ?int
    {
        return $this->cloud_cover;
    }

    public function setCloudCover(?int $cloud_cover): self
    {
        $this->cloud_cover = $cloud_cover;
        return $this;
    }
}