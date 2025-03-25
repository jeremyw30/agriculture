<?php
// filepath: src/Service/ServerTimeService.php

namespace App\Service;

use DateTime;
use Exception;

class ServerTimeService
{
    private const REAL_TO_SERVER_RATIO = 3; // 1 real day = 3 server days
    private const DAYS_IN_MONTH = 30;
    private const DAYS_IN_SEASON = 90;

    private array $weatherCoefficients = [
        'Hiver' => ['soleil' => 2, 'pluie' => 3, 'neige' => 5, 'brouillard' => 2, 'minTemp' => -10, 'maxTemp' => 5],
        'Printemps' => ['soleil' => 6, 'pluie' => 3, 'neige' => 0, 'brouillard' => 1, 'minTemp' => 5, 'maxTemp' => 15],
        'Eté' => ['soleil' => 8, 'pluie' => 2, 'neige' => 0, 'brouillard' => 0, 'minTemp' => 15, 'maxTemp' => 30],
        'Automne' => ['soleil' => 4, 'pluie' => 4, 'neige' => 1, 'brouillard' => 3, 'minTemp' => 0, 'maxTemp' => 10]
    ];

    public function __construct()
    {
        // Set locale to ensure date parsing works correctly
        setlocale(LC_TIME, 'fr_FR.UTF-8');
    }

    /**
     * Get the current server time and related information.
     *
     * @return array Server time information
     * @throws Exception If date calculations fail
     */
    public function getServerTime(): array
    {
        // Get the current real time
        $realTime = time();

        // Define the base date
        $baseDateStr = "01-01-2025 01:01:01";
        $baseDate = DateTime::createFromFormat('d-m-Y H:i:s', $baseDateStr);
       
        if ($baseDate === false) {
            throw new Exception('Error: Invalid base date');
        }

        // Calculate the number of real seconds that have passed since the base date
        $baseTimestamp = $baseDate->getTimestamp();
        $realSecondsPassed = $realTime - $baseTimestamp;

        // Calculate the number of server seconds
        $serverSeconds = $realSecondsPassed * self::REAL_TO_SERVER_RATIO;

        // Add server seconds to the base date
        $baseDate->modify("+$serverSeconds seconds");
        $serverTime = $baseDate->getTimestamp();

        // Check if serverTime is correctly calculated
        if ($serverTime === false) {
            throw new Exception('Error: Invalid server time calculation');
        }

        // Calculate server date components
        $serverYear = date('Y', $serverTime);
        $serverMonth = date('m', $serverTime);
        $serverDay = date('d', $serverTime);
        $serverHour = date('H', $serverTime);
        $serverMinute = date('i', $serverTime);

        // Determine the current season
        $serverDayOfYear = date('z', $serverTime) + 1; // Day of the year (1-365)
        $seasonNumber = ceil($serverDayOfYear / self::DAYS_IN_SEASON);

        $seasons = ['Hiver', 'Printemps', 'Eté', 'Automne'];
        $currentSeason = $seasons[($seasonNumber - 1) % 4];

        // Determine if it is day or night
        $isDay = $this->generateDayNight($currentSeason, $serverHour);

        // Determine the weather condition and temperature
        $weather = $this->determineWeather($currentSeason, $isDay);
        $temperature = $this->generateTemperature($currentSeason, $weather, $isDay);

        return [
            'serverTime' => date('d-m-Y H:i', $serverTime),
            'serverYear' => $serverYear,
            'serverMonth' => $serverMonth,
            'serverDay' => $serverDay,
            'serverHour' => $serverHour,
            'serverMinute' => $serverMinute,
            'currentSeason' => $currentSeason,
            'weather' => $weather,
            'temperature' => $temperature,
            'isDay' => $isDay
        ];
    }

    /**
     * Determine weather conditions based on season and time of day.
     */
    private function determineWeather(string $season, bool $isDay): string
    {
        $coefficients = $this->weatherCoefficients[$season];
        $totalCoeff = $coefficients['soleil'] + $coefficients['pluie'] + $coefficients['neige'] + $coefficients['brouillard'];
        $weather = rand(1, $totalCoeff);

        if ($isDay) {
            if ($weather <= $coefficients['soleil']) {
                return 'soleil';
            } elseif ($weather <= $coefficients['soleil'] + $coefficients['pluie']) {
                return 'pluie';
            } elseif ($weather <= $coefficients['soleil'] + $coefficients['pluie'] + $coefficients['brouillard']) {
                return 'brouillard';
            } else {
                return 'neige';
            }
        } else {
            if ($weather <= $coefficients['pluie']) {
                return 'pluie';
            } elseif ($weather <= $coefficients['pluie'] + $coefficients['brouillard']) {
                return 'brouillard';
            } else {
                return 'neige';
            }
        }
    }

    /**
     * Generate temperature based on season, weather, and time of day.
     */
    private function generateTemperature(string $season, string $weather, bool $isDay): int
    {
        $coefficients = $this->weatherCoefficients[$season];
        $baseTemp = rand($coefficients['minTemp'], $coefficients['maxTemp']);

        // Adjust temperature based on weather condition
        switch ($weather) {
            case 'soleil':
                $baseTemp += 5;
                break;
            case 'pluie':
                $baseTemp -= 5;
                break;
            case 'brouillard':
                $baseTemp -= 2;
                break;
        }

        // Adjust temperature based on time of day
        if ($isDay) {
            $baseTemp += 3; // Daytime adjustment
        } else {
            $baseTemp -= 3; // Nighttime adjustment
        }

        return $baseTemp;
    }

    /**
     * Determine if it's day or night based on season and hour.
     */
    private function generateDayNight(string $season, int $hour): bool
    {
        return match ($season) {
            'Hiver' => ($hour >= 8 && $hour < 17),
            'Printemps' => ($hour >= 6.5 && $hour < 20),
            'Eté' => ($hour >= 5.5 && $hour < 21.5),
            'Automne' => ($hour >= 7 && $hour < 18.5),
            default => false,
        };
    }
}