<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <style>
            input[type="textpreg"] {
               border:none; /* Get rid of the browser's styling */
               border-bottom:1px solid black; /* Add your own border */
               padding-bottom: 0px;
            }

            .row-bottom-margin {margin-bottom: -16px;  }
            
        </style>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <title>Retroalimentación Chatbot</title>
        @livewireStyles

        <div class="container-fluid">
            <div style="background-color:#050566" class="row">
                <div style="margin-top:1% ; margin-bottom:1%" class="col-md-4 text-center">
                    <img src="{{ asset('/images/logo-blanco.png') }}" class="logo" width="200" height="70" >
                </div>
                <div style="margin-top:1%" class="col-md-4 text-center">
                    <h3 style="color:white">Retroalimentación de ICI-BOT</h3>
                    <a style="color:rgb(170,170,170)">El chatbot de Ingeniería Civil Informática de la UCM</a>
                </div>
                <div style="margin-top:1% ; margin-bottom:1%" class="col-md-4 text-center">
                    <img src="{{ asset('/images/bot.png') }}" class="logo" width="100" height="70" >
                </div>
            </div>
        </div>

    </head>
    <body>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

        <div class="container-fluid">
            <br><div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <h5 class="card-header text-center">
                            Formulario de retroalimentación de ICI-BOT
                        </h5>
                        <div class="card-body">
                            <p class="card-text">
                                En este sitio, puedes sugerir nuevas preguntas para agregar a nuestro chatbot, o realizar algún comentario sobre este, rellenando uno de los formularios que se muestran a continuación. ICI-BOT está disponible en http://localhost:8000.
                            </p>
                        </div>
                    </div>
                </div>
            </div><br>

            <div class="row justify-content-center">
                <div class="col-md-10 border">
                    <div class="row justify-content-center">
                <div class="col-md-11 center">
                    <br><nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tabs" role="tablist">
                            <a class="nav-item nav-link active" id="nav-sugerencias-tab" data-toggle="tab" href="#nav-sugerencias" role="tab" aria-controls="nav-sugerencias" aria-selected="true"><p><i class="material-icons">quiz</i><strong> Sugerir nuevas preguntas</strong></p></a>
                            <a class="nav-item nav-link" id="nav-comentarios-tab" data-toggle="tab" href="#nav-comentarios" role="tab" aria-controls="nav-comentarios" aria-selected="false"><p><i class="material-icons">rate_review</i><strong>Comentarios y sugerencias</strong></p></a>
                      </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-sugerencias" role="tabpanel" aria-labelledby="nav-sugerencias-tab">
                            <p>
                                @livewire('crear-pregsugerencias')
                            </p>
                        </div>
                        <div class="tab-pane fade" id="nav-comentarios" role="tabpanel" aria-labelledby="nav-comentarios-tab">
                            <p>
                                @livewire('crear-comentario')
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </div>

        @stack('modals')
        @livewireScripts

    </body>
</html>

