<?php

namespace App\Enum;

enum BatimentTypeEnum: string
{
    case GRANGE = 'grange';
    case ETABLE = 'etable';
    case HANGAR = 'hangar';
    case SILO = 'silo';
    case POULAILLER = 'poulailler';
    case PORCHERIE = 'porcherie';
}