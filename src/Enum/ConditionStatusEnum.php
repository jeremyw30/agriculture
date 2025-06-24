<?php

namespace App\Enum;

enum ConditionStatusEnum: string
{
    case EXCELLENTE = 'excellente';
    case BONNE = 'bonne';
    case MOYENNE = 'moyenne';
    case PAUVRE = 'pauvre';
}