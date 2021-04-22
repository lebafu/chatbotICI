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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar QNA') }}</div>

               <div class="card-body">
                    <form action="{{route('qna.update', $question->id)}}" method="POST" enctype="multipart/form-data">
                       @csrf
                       @method('PUT')

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Id') }}</label>

                            <div class="col-md-6">
                                <input id="id" type="number" class="form-control" name="id" value="{{ $question->id }}" required autocomplete="nombre" autofocus readonly>

                              
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Pregunta') }}</label>

                            <div class="col-md-6">
                                <input id="pregunta" type="text" class="form-control" name="pregunta" value="{{ $question->pregunta}}" required autocomplete="respuestas" autofocus>

                              
                            </div>
                        </div>

                        @if($pos==0)
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Respuesta') }}</label>
                            <div class="col-md-6">
                                <input id="respuesta" type="text" class="form-control" name="respuesta" value="{{$answer->nombre}}" required autocomplete="nombre">
                            </div>
                        </div>
                         @elseif($pos==1)
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Respuesta') }}</label>

                            <div class="col-md-6">
                                <input id="respuesta" type="text" class="form-control" name="respuesta" value="{{$answer->nombre}}" required autocomplete="nombre" readonly="readonly">
                            </div>
                        </div>

                        <div>
                            <label for="img" class="negrita">La imagen seleccionada fue:</label>
                            <input name="imagen" type=text class="form-control" value="{{$name_image}}" readonly="readonly" hidden="hidden">
                            <img src="images/bp/{{ $name_image }}">
                        </div>
                       
                        <div>
                             <label>Cambiar Imagen: </label>
                            <input type="file" id="image_nueva" name="image_nueva" class="form-control"/>
                        <div class='text-danger'>{{$errors->first('image_nueva')}}</div>
                        </div>

                        <!--<img >-->
                       @endif

                         

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar') }}
                                </button>

                                <a href="/qna_index" class="btn">{{ __('Cancelar') }}</a>
                                    
                            </div>

                                
                            
                        </div>
                     
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>

