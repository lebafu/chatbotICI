<x-app-layout>

   <style>
        input[type="text"] {
           border:none; /* Get rid of the browser's styling */
           border-bottom:1px solid black; /* Add your own border */
           padding-bottom: 0px;
        }

        .row-bottom-margin {margin-bottom: -15px;  }

    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Preguntas sugeridas por los estudiantes') }}
        </h2>
    </x-slot>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <div class="container-fluid">
        <div class="row justify-content-center">
            @livewire('index-preg-sugeridas')   
        </div>
    </div>

</x-app-layout>