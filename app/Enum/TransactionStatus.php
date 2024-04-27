<?php

namespace App\Enum;

enum TransactionStatus: string
{
    case Chargeback = 'chargeback'; //Estorno
    case Pending = 'pending'; //Pendente
    case Expired = 'expired'; //Expirado
    case Error = 'error'; //Erro
    case Processing = 'processing'; //Processando
    case Refused = 'refused'; //Recusado
    case WaitingPayment = 'waiting_payment'; //Aguardando pagamento
    case Approved = 'approved'; //Aprovado
    case Canceled = 'canceled'; //Cancelado

}
