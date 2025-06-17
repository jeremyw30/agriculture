<?php

namespace App\Enum;

enum SolType: string
{
    case ARGILE = 'argile';
    case SABLE = 'sable';
    case LIMON = 'limon';
    case CALCAIRE = 'calcaire';
    case TERRE_NOIRE = 'terre_noire';

    public function getLabel(): string
    {
        return match($this) {
            self::ARGILE => 'Argile',
            self::SABLE => 'Sable',
            self::LIMON => 'Limon',
            self::CALCAIRE => 'Calcaire',
            self::TERRE_NOIRE => 'Terre noire',
        };
    }
}