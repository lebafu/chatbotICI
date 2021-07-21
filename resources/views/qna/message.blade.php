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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <b><div class="card-header">Actualizacion exitosa</div></b>
                        <form>

                                        @if($es_archivo_flow==null)   
                                                 @if ($message = Session::get('success'))
                                                        <div class="alert alert-success">
                                                        <p>{{ $message }}</p>
                                                         </div>
                                                    @endif
 
                                                <p>El archivo Modificado fue<p>
                                                    <p>Pregunta:{{$question->pregunta}}<p>
                                                    <p>Respuesta:{{$answer->nombre}} </p>
                                                    @if($imagen!=null)
                                                    <img src="images/bp/{{$imagen->nombre_imagen_qna}}">
                                                    @endif

                                       @else
                                                         <!--<img src="images/bp/{{$imagen_actual[0]}}">-->
                                            @for($i=0;$i<$tam_array_builtins_texts_unique;$i++)
                                                    <p>El <b>"{{$textos_iniciales[$i]}}"<b>fue actualizado a:<p>
                                                    <p><b>"{{$textos_finales[$i]}}"<b>.<p>
                                            @endfor
                                        @endif

                                         @for($i=0;$i<$tam_array_imagen;$i++)
                                            <!--<p>En la actualización las imagenes son:</p>-->
                                             @if((!empty($imagen_actual[$i]))==true)
                                                <p>Malla {{$names_imagenes[$i]}}</p>
                                                <img src="images/bp/{{$imagen_actual[$i]}}">
                                            @endif
                                            @endfor

                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
<a href="dashboard">Ir Dashboard</a>
</x-app-layout>






