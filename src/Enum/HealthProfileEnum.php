<?php

namespace App\Enum;

enum HealthProfileEnum: string
{
    case BONNE = 'bonne';
    case MALADE = 'malade';
    case CRITIQUE = 'critique';
}