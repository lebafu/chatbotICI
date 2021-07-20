<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>UCMBot</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
        <!-- Styles -->

<style>
body {
    font-family: 'Nunito';
}
.col-1 {
    width: 70%;
    height: 100%;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    float: left;
}
.col-2 {
    width: 30%;
    height: 100%;
    float: right;
}
.login {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-content: center;
    margin-top: 0%;
}
.login img {
    width: 100%;
    height: 100%;
}
.login h4 {
    width: 80%;
    font-size: 24px;
    text-align: center;
    color: #002A61;
}
.login form {
    margin-top: 8%;
    width: 70%;
}
</style>
    </head>
    <body class="antialiased">
                <!--<div class="col-1"></div>-->
    <div id="login" class="col-2">
        <div class="login">
            <form id="form1" @submit.prevent="submit()">
                <div class="center-align">
                   @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                    @else
                        <x-guest-layout>
                            <x-jet-authentication-card>
                                <x-slot name="logo">
                                    <img src="images/logo.png">
                                </x-slot>

                                <x-jet-validation-errors class="mb-4" />

                                @if (session('status'))
                                    <div class="mb-4 font-medium text-sm text-green-600">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div>
                                        <x-jet-label for="email" value="{{ __('Email') }}" />
                                        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                                    </div>

                                    <div class="mt-4">
                                        <x-jet-label for="password" value="{{ __('Password') }}" />
                                        <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                                    </div>

                                    <div class="block mt-4">
                                        <label for="remember_me" class="flex items-center">
                                            <x-jet-checkbox id="remember_me" name="remember" />
                                            <span class="ml-2 text-sm text-gray-600">{{ __('Recuérdame') }}</span>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-end mt-4">
                                        @if (Route::has('password.request'))
                                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                                {{ __('¿Olvidaste tu contraseña?') }}
                                            </a>
                                        @endif

                                        <x-jet-button class="ml-4">
                                            {{ __('Iniciar Sesión') }}
                                        </x-jet-button>
                                    </div>
                                </form>
                               </x-jet-authentication-card>
                        </x-guest-layout>
                    @endauth
                </div>
            </form>
        <form id="form2" action="{{route('qna.pregunta_sin_respuesta')}}" method="post">
                @csrf
            <b>Envie sus preguntas para retroalimentar nuestro sistema,debe separarlas por coma</b>
            <textarea name="preguntas" rows="10" cols="20" placeholder="Escriba Aqui Sus Preguntas"></textarea>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
        </div>
    
    </div>
                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                       <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                         <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                 <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="images/foto1.jpg" style="float:left" width="790" height="500">
                            </div>
                            <div class="carousel-item">
                                <img src="images/foto2.jpg" style="float:left" width="790" height="500">
                            </div>
                            <div class="carousel-item">
                                 <img src="images/foto3.jpg" style="float:left" width="790" height="500">
                            </div>  
                        </div>
                        <button class="carousel-control-prev" style="float:left" type="button" data-bs-target="#carouselExampleIndicators"  data-bs-slide="prev">
                         <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                         <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"  data-bs-slide="next">
                         <span class="carousel-control-next-icon" aria-hidden="true" style="float:left"></span>
                         <span class="visually-hidden">Next</span>
                        </button>
                    </div>
            </div>


    </body>
</html>
