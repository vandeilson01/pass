<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transaction\GetTransactionsResource;
use App\Models\Transaction;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;

class GetTransactionsController extends Controller
{
    public function __invoke(): JsonResource
    {
        $user = auth()->user();

        $transactions = QueryBuilder::for(Transaction::class)
            ->where('user_id', $user->id)
            ->allowedFilters(['name'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return GetTransactionsResource::collection($transactions);
    }
}
