<?php

use Illuminate\Http\Request;
use App\Events\CashoutGameEvent;
use App\Http\Controllers\Admin\Reports\GamesStatisticsReportController;
use App\Http\Controllers\Api\Account\ChangePasswordController;
use App\Http\Controllers\Api\Account\GetProfileController;
use App\Http\Controllers\Api\Account\UpdateProfileController;
use App\Http\Controllers\Api\Affiliate\GetStatisticsController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\MeController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Games\Crash\AddBetGameController;
use App\Http\Controllers\Api\Games\Crash\CashoutGameController as CashoutCrashGameController;
use App\Http\Controllers\Api\Games\Crash\CreateFakeBetsController;
use App\Http\Controllers\Api\Games\Crash\CreateFakeCashoutsController;
use App\Http\Controllers\Api\Games\Crash\GetCrashGameController;
use App\Http\Controllers\Api\Games\Double\AddBetGameController as AddBetDoubleGameController;
use App\Http\Controllers\Api\Games\Double\GetDoubleGameController;
use App\Http\Controllers\Api\Games\GameProvider\GetGameProviderController;
//use App\Http\Controllers\Api\Games\Integrations\Ezzugi\WebhookController;
use App\Http\Controllers\Api\Games\Mines\CashoutGameController as CashoutMinesGameController;
use App\Http\Controllers\Api\Games\Mines\GetGameController;
use App\Http\Controllers\Api\Games\Mines\PlayGameController;
use App\Http\Controllers\Api\Games\Mines\StartGameController;
use App\Http\Controllers\Api\Payment\Cashout\RequestCashoutController;
use App\Http\Controllers\Api\Payment\Deposit\AddCreditController;
use App\Http\Controllers\Api\Payment\ReturnGatewayController;
use App\Http\Controllers\Api\Transaction\GetTransactionsController;
use App\Http\Controllers\Api\Wallet\GetBalanceController;
use App\Http\Controllers\Api\Wallet\GetBonusController;
use App\Http\Controllers\Api\Wallet\GetWalletsController;
use App\Http\Controllers\UsersAdmin;

use App\Jobs\Utils\ReprocessAllTransactionsByUserJob;
use App\Models\Games\CrashBet;
use App\Models\Games\Mines;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
 

Route::prefix('payment')->as('payment.')->group(function () {
    Route::post('/return/{gateway:slug}', ReturnGatewayController::class)->name('return');
});

Route::prefix('games')->as('games.')->group(function () {
    Route::prefix('crash')->as('crash.')->group(function () {
        Route::get('/', GetCrashGameController::class)->name('get');
        Route::post('/create-fake-bets', CreateFakeBetsController::class)->name('create-fake-bets');
        Route::post('/create-fake-cashouts', CreateFakeCashoutsController::class)->name('create-fake-cashouts');
    });

    Route::prefix('double')->as('double.')->group(function () {
        Route::get('/', GetDoubleGameController::class)->name('get');
    });

    Route::prefix('game-provider')->as('game-provider.')->group(function () {
        Route::get('/{game:slug}',  GetGameProviderController::class)->name('get');
    });
});


//Route::get('users-admin',UsersAdmin::class)->name('user-admin');

Route::as('auth.')->group(function () {
    Route::post('login', LoginController::class)->name('login');
    Route::post('register', RegisterController::class)->name('register');
    Route::post('forgot-password', ForgotPasswordController::class)->name('forgot-password');
    Route::post('reset-password', ResetPasswordController::class)->name('reset-password');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', MeController::class)->name('me');
        Route::post('logout', LogoutController::class)->name('logout');


        Route::prefix('account')->as('account.')->group(function () {
            Route::get('profile', GetProfileController::class)->name('profile');
            Route::put('profile', UpdateProfileController::class)->name('profile.update');
            Route::put('change-password', ChangePasswordController::class)->name('change-password');
        });

        Route::prefix('payment')->as('payment.')->group(function () {
            Route::prefix('deposit')->as('deposit.')->group(function () {
                Route::post('add-credit', AddCreditController::class)->name('add-credit');
            });

            Route::prefix('cashout')->as('cashout.')->group(function () {
                Route::post('request-cashout', RequestCashoutController::class)->name('request-cashout');
            });
        });

        Route::prefix('wallet')->as('wallet.')->group(function () {
            Route::get('/get-balance', GetBalanceController::class)->name('get-balance');
            Route::get('/bonus', GetBonusController::class)->name('bonus');
            Route::get('/get-wallets', GetWalletsController::class)->name('get-wallets');
        });

        Route::get('/transactions', GetTransactionsController::class)->name('transactions');

        Route::prefix('affiliate')->as('affiliate.')->group(function () {
            Route::get('get-statistics', GetStatisticsController::class)->name('get-statistics');
        });


        Route::prefix('games')->as('games.')->group(function () {
            Route::prefix('mines')->as('mines.')->group(function () {
                Route::get('/', GetGameController::class)->name('get');
                Route::post('/', StartGameController::class)->name('start');
                Route::post('/play', PlayGameController::class)->name('play');
                Route::post('/cashout', CashoutMinesGameController::class)->name('cashout');
            });

            Route::prefix('crash')->as('crash.')->group(function () {
                Route::post('/', AddBetGameController::class)->name('add-bet-game');
                Route::post('/cashout', CashoutCrashGameController::class)->name('cashout');
            });

            Route::prefix('double')->as('double.')->group(function () {
                Route::post('/', AddBetDoubleGameController::class)->name('add-bet-game');
            });

            Route::prefix('game-provider')->as('game-provider.')->group(function () {
                Route::get('/start-game/{game:slug}',  \App\Http\Controllers\Api\Games\Integrations\StartGameController::class)->name('start-game');
            });
        });

    });
});


Route::get('/find-transactions-deleted', function () {
    $transactions = Transaction::query()
        ->withTrashed()
        ->whereNotNull('deleted_at')
        ->forceDelete();

    return $transactions;
});

Route::get('/find-bug-mines', function () {
    //passo 1 - deletar transacoes duplicadas
    $mines = Mines::query()
        ->has('transaction', '>', 2)
        ->get();

    foreach ($mines as $mine) {
        $transacao = Transaction::query()
            ->where('typable_type', 'App\Models\Games\Mines')
            ->where('typable_id', $mine->id)
            ->where('type', 'credit')
            ->forceDelete();
    }

    // passo 2 - recriar transacoes
    $mines = Mines::query()
        ->with('transaction')
        ->where('win', true)
        ->whereDoesntHave('transaction', function ($query) {
            $query->where('type', 'credit');
        })
        ->get();

    foreach ($mines as $mine) {
        CashoutGameEvent::dispatch($mine);
    }

    return $mines;
});

Route::get('/find-bug-crash', function () {
    //1 passo - deletar retiradas duplicadas
    $crashbets = CrashBet::query()
        ->has('transaction', '>', 2)
        ->get();

    foreach ($crashbets as $crashbet) {
        $transacao = Transaction::query()
            ->where('typable_type', 'App\Models\Games\CrashBet')
            ->where('typable_id', $crashbet->id)
            ->where('type', 'credit')
            ->forceDelete();
    }

    //2 passo - buscar apostas ganhas sem transacao
    $crashbets = CrashBet::query()
        ->with('transaction')
        ->where('win', true)
        ->where('fake', false)
        ->whereDoesntHave('transaction', function ($query) {
            $query->where('type', 'credit');
        })
        ->get();

    foreach ($crashbets as $crashbet) {
        CashoutGameEvent::dispatch($crashbet);
    }

    return $crashbets;
});

//Route::post("/betsac/webhook", WebhookController::class)->name("betsac.webhook");