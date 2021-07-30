<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <title>Retroalimentación Chatbot</title>

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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Comentario ha sido almacenado correctamente en la base de datos') }}</div>
                        <table class="table table-bordered">

                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<input type="button" value="Página anterior" onClick="history.go(-1);">