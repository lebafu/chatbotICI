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



<div class="container">
	<div class="container">
 	 	<div class="row justify-content-center">
    		<div class="col-md-8">
      			<div class="card">
       				<div class="card-header">{{ __('Informacion detallada Comentario') }}</div>
          				<div class="card-body">

    <table class="table table-bordered">
        <tr>

	<b>Id</b>
	<p>{{$comentario->id}}</p>
	<b>Nombre</b>
	<p>{{$comentario->nombre}}</p>
	<b>Email</b>
	<p>{{$comentario->email}}</p>
	<b>Comentario</b>
	<p>{{$comentario->comentarios_y_sugerencias}}</p>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<a href="{{ url()->previous() }}" class="btn btn-default">Volver atrás</a>
</tr>
 </table>
</x-app-layout>