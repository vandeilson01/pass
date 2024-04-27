<?php

namespace App\Enum;

enum DoubleStatus: string
{
    case Pending = 'pending'; //Pendente
    case Started = 'started'; //Iniciado
    case Finished = 'finished'; //Finalizado
}
