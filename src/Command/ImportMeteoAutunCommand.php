<?php
namespace App\Command;

use App\Entity\MeteoData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class ImportMeteoAutunCommand extends Command
{
    protected static $defaultName = 'app:import-meteo-autun';

    private $entityManager;
    private $filesystem;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->filesystem = new Filesystem();
    }

    protected function configure()
    {
        $this
            ->setDescription('Imports meteorological data from JSON file')
            ->addOption('file', null, InputOption::VALUE_OPTIONAL, 'Path to the JSON file', 'assets/data/meteo-autun-2024.json')
            ->setName('app:import-meteo-autun');
        }

    protected function execute(InputInterface $input, OutputInterface $output):int
    {
        $filePath = $input->getOption('file');

        if (!$this->filesystem->exists($filePath)) {
            $output->writeln("<error>File not found: $filePath</error>");
            return Command::FAILURE;
        }

        $jsonData = json_decode(file_get_contents($filePath), true);

        foreach ($jsonData as $entry) {
            if (isset($entry['data']['data'])) {
                foreach ($entry['data']['data'] as $weatherData) {
                    $meteoData = new MeteoData();
                    $meteoData->setDate(new \DateTime($weatherData['date']));
                    $meteoData->setTemperature($weatherData['temperature']);
                    $meteoData->setFeelsLike($weatherData['feels_like']);
                    $meteoData->setHumidity($weatherData['humidity']);
                    $meteoData->setWindSpeed($weatherData['wind']['speed'] ?? null);
                    $meteoData->setWindDirection($weatherData['wind']['dir'] ?? null);
                    $meteoData->setPressure($weatherData['pressure']);
                    $meteoData->setPrecipitationType($weatherData['precipitation']['type'] ?? null);
                    $meteoData->setWeather($weatherData['weather']);
                    $meteoData->setSummary($weatherData['summary']);
                    $meteoData->setCloudCover($weatherData['cloud_cover']['total'] ?? null);
                    $meteoData->setZone('Autun');
                    $this->entityManager->persist($meteoData);
                }
            }
        }

        $this->entityManager->flush();
        $output->writeln("<info>Data imported successfully!</info>");

        return Command::SUCCESS;
    }
}