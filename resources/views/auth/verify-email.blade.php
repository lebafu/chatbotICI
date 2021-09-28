<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img src="images/logo.png">
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Gracias por registrarte! Verifica tu dirección de correo electrónico haciendo clic en el enlace que le acabamos de enviar. Si no recibió el correo electrónico le podemos enviar otro.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Se ha enviado un nuevo enlace de verificación a su correo electrónico.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-jet-button type="submit">
                        {{ __('Reenviar correo de verificación') }}
                    </x-jet-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Cerrar sesión') }}
                </button>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
