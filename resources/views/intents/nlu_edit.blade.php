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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar nlu') }}</div>

                <div class="card-body">
                    <form action="{{route('intents.nlu_update', $nlu_question->id)}}" method="POST">
                       @csrf
                       @method('PUT')

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Id') }}</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control" name="nombre" value="{{ $nlu_question->id }}" required autocomplete="nombre" autofocus disabled>

                              
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control" name="nombre" value="{{ $nlu_name1->nombre }}" required autocomplete="nombre" autofocus disabled>

                              
                            </div>
                        </div>

                       <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Expresión equivalente para nombre') }}</label>

                            <div class="col-md-6">
                                <input id="respuestas" type="text" class="form-control" name="respuestas" value="{{ $nlu_question->respuestas }}" required autocomplete="respuestas" autofocus>

                              
                            </div>
                        </div>

                        @for($i=0;$i<$cantidad_image;$i++)
                       <div>
                            <b><label for="img" class="negrita">{{$array_name[2*$i+2]}}</label></b>
                            <input name="imagen{{$i}}" type=text class="form-control" value="{{$array_ruta_image[$i]}}" readonly="readonly" hidden="hidden">
                            <img src="images/bp/{{$array_ruta_image[$i]}}">
                        </div>
                       
                        <div>
                             <label>Cambiar Imagen: </label>
                            <input type="file"  id="image_nueva{{$i}}" name="image_nueva{{$i}}" class="form-control-file"  accept="image/*" />
                            <!--<div class='text-danger'>{{$errors->first('image_nueva$i')}}</div>-->
                            @if($i==0)
                            @error('image_nueva0')
                                <small class='text-danger'>{{$message}}</small>
                            @enderror
                            @endif
                            @if($i==1)
                            @error('image_nueva1')
                                <small class='text-danger'>{{$message}}</small>
                            @enderror
                            @endif
                        </div>
                        

                        <!--<img >-->
                    
                        @endfor
                       
                     <!-- Colocar campo Hidden para ocultar cantidad_image y saber cuantas imagenes debo modificar -->
                       <input type="hidden" name="cantidad_image" value="{{$cantidad_image}}">
                      
                         

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar') }}
                                </button>

                                <a href="/" class="btn">{{ __('Cancelar') }}</a>
                                    
                            </div>


                                
                            
                        </div>
                     
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>