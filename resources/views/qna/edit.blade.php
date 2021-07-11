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
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar QNA') }}</div>

               <div class="card-body">
                    <form action="{{route('qna.update', $question->id)}}" method="POST" enctype="multipart/form-data">
                       @csrf
                       @method('PUT')

                       @if($es_archivo_flow==false)
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
                       @else
                           <b>Nota: El término \n representa el salto de línea en el chatbot, si lo cree necesario en la oración no lo elimine.</b>
                            @for($i=0;$i<$tam_array_builtins_texts_unique;$i++)
                            <input  id="builtins_texts_index_unique{{$i}}" type="hidden" class="form-control" name="builtins_texts_unique[]" value="{{$builtins_texts_index_unique[$i]}}" required>
                            @endfor

                            @for ($i=2; $i<$tam_array_todo;$i=$i+3)
                             @if($todo_ordenado[$i-1]=="builtin_image")

                            <label for="img" class="negrita">La imagen seleccionada fue:Malla {{$nombres_imagenes[$i-1]}}</label>
                            <input  id="nombres_imagenes{{$i}}" type="hidden" class="form-control" name="imagenes_news[]" value="{{$nombres_imagenes[$i-1]}}" required>

                            <img src="images/bp/{{$todo_ordenado[$i]}}">
                            <input id="imagen_actual{{$i}}" name=imagen_actual[] type="text" value="{{$todo_ordenado[$i]}}" hidden>
                            <label for="img" class="negrita">Cambiar la imagen:</label>
                            <input id="imagen_nueva{{$i}}" name="imagen_nueva[]" type="file" class="form-control">
                            @elseif($todo_ordenado[$i-1]=="builtin_text")
                                        <input  id="string{{$i}}" type="text" class="form-control" name="string[]" value="{{$todo_ordenado[$i]}}"  onkeyup="PasarValor(5);" required>
                                      <input  id="textos_originales{{$i}}" type="hidden" class="form-control" name="textos_originales[]" value="{{$todo_ordenado[$i]}}" required>
                                      <input type="hidden" id="builtin_tipo{{$i-1}}" name="builtin_tipo[]" value="{{$todo_ordenado[$i-1]}}">
                                       <input type="hidden" id="builtin_codigo{{$i-2}}" name="builtin_codigo[]" value="{{$todo_ordenado[$i-2]}}">


                                    @endif
                            @endfor
                         
                        @endif
                        <input type="hidden" id="es_archivo_flow" name="es_archivo_flow" value="{{$es_archivo_flow}}">
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

<script>
function PasarValor($i)
{
    //if($i!=$j){
document.getElementById("string11").value = document.getElementById("string5").value;
document.getElementById("string17").value = document.getElementById("string5").value;
document.getElementById("string23").value = document.getElementById("string5").value;
//}
}
</script>
