<?php

namespace App\Enum;

enum FertilityLevelEnum: string
{
    case FAIBLE = 'faible';
    case MOYENNE = 'moyenne';
    case BONNE = 'bonne';
    case EXCELLENTE = 'excellente';
}