<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

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
                <div class="col-md-8">
                    <div class="tabbable" id="tabs-947638">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link" href="#tab1" data-toggle="tab">Sugerir nuevas preguntas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab2" data-toggle="tab">Comentarios y sugerencias</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" id="tab1">
                                <p>
                                    @livewire('crear-pregsugerencias')
                                </p>
                            </div>
                            <div class="tab-pane" id="tab2">
                                <p>
                                    @livewire('crear-comentario')
                                </p>
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