<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>


            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
            </div>


            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>


            <div class="mt-4">
                <x-label value="{{ __('Comission rate (%)') }}" />
                <span>$100 Real Money (10%) for $1,000 Game Money</span>
                <x-input class="block mt-1 w-full" type="text" required name="comission" :value="old('comission')" 
                required autofocus autocomplete="comission" />
            </div>

            <div class="mt-4">
                <x-label value="{{ __('Currency') }}" />
                <select name="currency" id="underline_select" required class="block py-2.5 px-0 w-full text-sm text-gray-500  border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                    <option selected>Choose a country</option>
                    <option value="BR">BR</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="IDR">IDR</option>
                    <option value="INR">INR</option>
                    <option value="ARS">ARS</option>
                    <option value="PEN">PEN</option>
                    <option value="CNY">CNY</option>
                    <option value="KRM">KRM</option>
                    <option value="JPY">JPY</option>
                    <option value="MNT">MNT</option>
                    <option value="THB">THB</option>
                    <option value="PHP">PHP</option>
                    <option value="VND">VND</option>
                    <option value="MYR">MYR</option>
                    <option value="TND">TND</option>
                </select>
            </div>

            <div class="mt-4">
                <x-label value="{{ __('Agent Type') }}" />
                <select name="agent_type" id="underline_select" required class="block py-2.5 px-0 w-full text-sm text-gray-500  border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                    <option selected>Choose a country</option>
                    <option value="affiliate">Affiliate (You can also use API and create child agents.)</option>
                    <option value="operator">Operator (Only API is used and child agents cannot be created.)</option>
                </select>
            </div>

            <div class="mt-4">
                <x-label value="{{ __('API Type') }}" />
                <select name="api_type" id="underline_select" required class="block py-2.5 px-0 w-full text-sm text-gray-500  border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                    <option selected>Choose a country</option>
                    <option value="seamless">Seamless</option>
                    <option value="transfer">Transfer</option>
                </select>
            </div>

            <div class="mt-4">
                <x-label value="{{ __('Callback Adrress') }}" />
                <span>(ex: https://www.yoursite.com/callback_api)</span>
                <x-input class="block mt-1 w-full" type="text"  name="callback" :value="old('callback')" 
                required autofocus autocomplete="callback" />
            </div>



            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif



            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
