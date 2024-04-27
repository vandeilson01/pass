<?php

namespace App\Enum;

enum PixKeyType: string
{
    case Cpf = 'cpf';
    case Email = 'email';
    case Phone = 'phone';
    case Random = 'random';
}
