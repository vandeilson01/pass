<?php

namespace App\Enum;

enum CrashStatus: string
{
    case Pending = 'pending'; //Pendente
    case Started = 'started'; //Iniciado
    case Crashed = 'crashed'; //Encerrado
}
