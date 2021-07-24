<x-app-layout>
    <style>
        .pageCenter {
    margin-left: auto;
    margin-right: auto;
    max-width: 1000px;
    float: none;
    }
    </style>
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Crear Q&A') }}</div>

                <div class="card-body">
                    <form action="{{route('qna.store')}}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <label for="question" class="col-md-4 col-form-label text-md-right">{{ __('Question') }}</label>

                            <div class="col-md-6">
                                <input id="question" type="text" class="form-control @error('name') is-invalid @enderror" name="question" value="{{ old('question') }}" required autocomplete="question" autofocus>

                                @error('question')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Answer') }}</label>

                            <div class="col-md-6">
                                <input id="answer" type="text" class="form-control @error('answer') is-invalid @enderror" name="answer" value="{{ old('answer') }}" required autocomplete="answer" autofocus>

                                @error('answer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                       <!-- <div class="form-group row">
                        <div class="col-md-6">
                        <input type="checkbox" id="contexto1" name="contexto1" value="global">
                        <label for="contexto1">Global</label><br>
                        <input type="checkbox" id="contexto2" name="contexto2" value="regular">
                        <label for="contexto2">Alumno Regular</label><br>
                        <input type="checkbox" id="contexto3" name="contexto3" value="egresado">
                        <label for="contexto3">Alumno Egresado</label><br><br>
                         </div>
                       </div>-->

                        <div class="form-group row">
                        <label for="contexto" class="col-md-4 col-form-label text-md-right">Seleccionar Contexto:</label>
                        <div class="col-md-6">
                            <select name="contexto" id="contexto">
                                <option value="global">Global</option>
                                <option value="regular">Alumno Regular</option>
                                <option value="egresado">Alumno Egresado</option>
                            </select>
                        </div>
                      </div>
              

                    <div class="form-group row">
                        <label for="vence" class="col-md-4 col-form-label text-md-right">Vence:</label>
                        <div class="col-md-6">
                            <select name="vence" id="vence" name="vence" onclick="showInp()">
                                <option value="">Seleccione una alternativa</option>
                                <option value="No">No</option>
                                <option value="Si">Si</option>
                           </select>
                        </div>
                    </div>

                    <div id="fecha_caducacion">
                        <div class="form-group row">
                            <label for="fecha" class="col-md-4 col-form-label text-md-right" >{{ __('Fecha Caducacion') }}</label>

                            <div class="col-md-6">
                                <div class='input-group date' id='datetimepicker'>
                                    <input type='text' class="form-control" />
                                        <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                            </div>
                        </div>
                    </div>

                     


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar') }}
                                </button>

                                <a href="/dashboard" class="btn">{{ __('Cancelar') }}</a>
                                    
                            </div>

        
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/locale/es.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
    $(function() {
           $('#datetimepicker').datetimepicker({
            format:'DD/MM/YYYY',
            locale: 'es',
           });
        }); 
function showInp(){
    vence =document.getElementById("vence").value;
    if(vence=="Si"){
       document.getElementById("fecha_caducacion").style.display="block";
    }
    if(vence=="No"){
        document.getElementById("fecha_caducacion").style.display="none";
    }
    if(vence==""){
        document.getElementById("fecha_caducacion").style.display="none";
    }
}

</script>




