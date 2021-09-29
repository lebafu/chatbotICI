<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Comentarios') }}
        </h2>
    </x-slot><br>
   
 @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif  

    @livewire('index-comentarios')

</x-app-layout>


