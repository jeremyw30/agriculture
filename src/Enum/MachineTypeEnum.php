<?php

namespace App\Enum;

enum MachineTypeEnum: string
{
    case TRACTEUR = 'tracteur';
    case MOISSONNEUSE = 'moissonneuse';
    case SEMOIR = 'semoir';
    case CHARRUE = 'charrue';
    case PULVERISATEUR = 'pulverisateur';
    case REMORQUE = 'remorque';
}