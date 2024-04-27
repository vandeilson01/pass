@php 
    use App\Models\Games\DoubleBet;
    use App\Models\Games\CrashBet;
    use App\Models\Games\Mines;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-2 flex flex-wrap items-center justify-center overflow-hidden shadow-xl sm:rounded-lg">

            
            <a href="#" class="block w-80 m-1  max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Bonus</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400"><?php 
                    $user = auth()->user()->load('bonus');
                    $bonus = $user->bonus->balance ?? 0;

                    echo $bonus;
                ?></p>
            </a>
            <a href="#" class="block w-80 m-1 max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Balance</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400"><?php 
                    $user = auth()->user()->load('bonus');
                    $balance = $user->wallet->balance ?? 0;

                    // echo $balance;

                    $currency = auth()->user()->currency ?? 'en_US';

                    setlocale(LC_MONETARY, $currency);
                    echo number_format($balance,2,",",".").' '.$currency;
                ?></p>
            </a>
            <a href="#" class="block w-80 m-1  max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Currency</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">
                <?php 
                    $currency = auth()->user()->currency;

                    echo $currency;
                ?>
                </p>
            </a>

            <!--  -->
 
            <a href="#" class="block w-80 m-1 max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Agent Type</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400"><?php 
                    $agent_type = auth()->user()->agent_type;

                    echo $agent_type;
                ?></p>
            </a>
            <a href="#" class="block w-80 m-1  max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">API Type</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400"><?php 
                    $api_type = auth()->user()->api_type;

                    echo $api_type;
                ?></p>
            </a>
            

            <!--  -->

            <a href="#" class="block w-80 m-1 max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Agent Rtp</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400"><?php 


                $r = DoubleBet::where('user_id', auth()->user()->id)->sum('bet');
                $p = CrashBet::where('user_id', auth()->user()->id)->sum('bet');
                $t = Mines::where('user_id', auth()->user()->id)->sum('bet');


                $rr = DoubleBet::where('user_id', auth()->user()->id)->count() != 0 ? DoubleBet::where('user_id', auth()->user()->id)->count() : 1;
                $pp = CrashBet::where('user_id', auth()->user()->id)->count() != 0 ? CrashBet::where('user_id', auth()->user()->id)->count() : 1;
                $tt = Mines::where('user_id', auth()->user()->id)->count() != 0 ? Mines::where('user_id', auth()->user()->id)->count() : 1;

                $rnew = ($r/$rr);
                $pnew = ($p/$pp);
                $tnew = ($t/$tt);

                $pass = (($rnew+$pnew)/2);
                echo (($pass*100)/$rnew+$pnew).'%';

                

                // echo CrashBet::where('id', auth()->user()->id)->get();

                //$comission = auth()->user()->comission;

                // echo $comission;
                ?></p>
            </a>
            <a href="#" class="block w-80 m-1  max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">GGR</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400"><?php 

 

                    $comission = auth()->user()->comission;

                    echo $comission ?? 0;
                ?></p>
            </a>
                

            </div>
        </div>

        <div class="py-12">
            
        </div>
    </div>

    <!-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div role="alert">
                    <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                        Danger
                    </div>
                    <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                        <p>Something not ideal might be happening.</p>
                    </div>
                </div>

                <div>dsdsd</div>
            </div>
        </div>
    </div> -->
</x-app-layout>
