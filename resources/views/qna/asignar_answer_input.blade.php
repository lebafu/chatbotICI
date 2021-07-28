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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Asignar Respuesta a Pregunta') }}</div>

               <div class="card-body">     
                    <form action="{{route('qna.update_asignar_input_respuesta', $question->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                       @method('PUT')
                        <div class="form-group row">
                          <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Id') }}</label>

                            <div class="col-md-6">
                                <input id="pregunta" type="text" class="form-control" name="id" value="{{ $question->id}}" required autocomplete="respuestas" autofocus readonly>
                              </div>
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Pregunta') }}</label>

                            <div class="col-md-6">
                                <input id="pregunta" type="text" class="form-control" name="question" value="{{ $question->pregunta_sin_respuesta}}" required autocomplete="respuestas" autofocus readonly>

                              </div>
                              <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Respuesta') }}</label>


                            <div class="col-md-6">
                                <input id="pregunta" type="text" class="form-control" name="answer" required autocomplete="respuestas" value="{{ old('answer') }}" autofocus required>
                              </div>
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