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
            {{ __('Comentarios') }}
        </h2>
    </x-slot>
   
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th width="250px">Comentario</th>
        </tr>
        @foreach ($datos as $dato)
        <tr>
            <td>{{$dato->id}}</td>
            <td>{{$dato->nombre}}</td>
            <td>{{$dato->comentarios_y_sugerencias}}</td>
            <td>
            <a class="btn btn-primary btn-xs" href="{{route('comentarios.show',$dato->id)}}"><span class="far fa-eye"style="color:black"></span></a>  
            <form action="{{ route('comentarios.destroy', $dato->id)}}" method="POST">
          <button type="submit" class="btn btn-danger btn-xs"><span class="fas fa-trash" style="color:black"></span>
           {{ method_field('DELETE') }}
           {{ csrf_field() }}
           </form>
       </td>
        </tr>
        @endforeach
    </table>
  

{{$datos->links()  }}
</x-app-layout>


