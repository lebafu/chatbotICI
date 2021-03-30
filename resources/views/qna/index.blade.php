<x-app-layout>
         <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

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
            {{ __('Qna') }}
        </h2>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Questions Answer') }}
        </h2>
    </x-slot>

    <a class="btn btn-primary" href="{{route('qna.create')}}">Create</a>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Preguntas</th>
            <th>Respuesta</th>
            <th width="250px">Action</th>
        </tr>
        @foreach ($datos as $dato)
        <tr>
            <td>{{ $dato->id}}</td>
            <td>{{ $dato->pregunta}}</td>
            <td>{{ $dato->nombre}}</td>
            <td>
                <!--
   
                    -->
    
                    <a class="btn btn-primary" href="{{route('qna.edit',$dato->id)}}">Editar</a>
                    @if($dato->habilitada==1)
                    <a class="btn btn-danger" href="{{route('qna.habilitada',$dato->id)}}">Deshabilitar</a>
                    @else
                    <a class="btn btn-success" href="{{route('qna.habilitada',$dato->id)}}">Habilitar</a>
                    @endif
            </td>
        </tr>
        @endforeach
    </table>
  

{{$datos->links()  }}
</x-app-layout>


