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
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Preguntas Sin Respuesta') }}
        </h2>
    </x-slot>


    <table class="table table-bordered center" >
        <tr>
            <th>ID</th>
            <th>Pregunta</th>
            <th>Acción</th>
        </tr>
        @foreach ($datos as $dato)
        <tr>
            <td>{{ $dato->id}}</td>
            <td>{{ $dato->pregunta_sin_respuesta}}</td>
            <td>
            <div class="row">
            <a class="btn btn-primary btn-xs" href="{{route('qna.asignar_respuesta',$dato->id)}}">Existente<span style="color:black"></span></a>
            <a class="btn btn-primary btn-xs" href="{{route('qna.asignar_answer_input',$dato->id)}}">Nueva<span style="color:black"></span></a>
             <a class="btn btn-primary btn-xs" href="{{route('qna.show_pregunta_sin_respuesta',$dato->id)}}"><span class="far fa-eye" style="color:black"></span></a>  
            <form action="{{ route('qna.eliminar_pregunta_sin_respuesta', $dato->id)}}" method="POST">
          <button type="submit" class="btn btn-danger"><span class="fas fa-trash" style="color:black"></span>
           {{ method_field('DELETE') }}
           {{ csrf_field() }}
            </button>
        </form>
           </div>
           </td>
        </tr>
        @endforeach
    </table>


{{$datos->links()  }}
</x-app-layout>


