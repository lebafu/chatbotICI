<x-app-layout>
        <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title>{{ config('app.name', 'UCMBot') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="http://localhost:3000/assets/modules/channel-web/inject.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Intenciones') }}
        </h2>
    </x-slot>
     <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Todas las intenciones de Aprendizaje del Lenguaje Natural</h2>
            </div>
            <div class="pull-right">
                
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>nombre</th>
            <th>Expresión equivalente para nombre</th>
            <th>Action</th>
        </tr>
        @foreach ($datos as $dato)
        <tr>
            <td>{{ $dato->id}}</td>
            <td>{{ $dato->nombre}}</td>
            <td>{{ $dato->respuesta}}</td>
            <td>
               
    
                    <a class="btn btn-primary" href="{{ route('intents.nlu_index',$dato->id) }}">Ver</a>
   
                
            </td>
        </tr>
        @endforeach
    </table>
    {{$datos->links()}}
            </div>
        </div>
    </div>
</x-app-layout>
   

