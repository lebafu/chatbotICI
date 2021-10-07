<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div class="row justify-content-center">
    <div class="col-md-3 ">
        <center>
        <img src="images/logo.png" class=" h-16 w-auto" />
    </center>
    </div>
    <div class="col-md-8">
        <div class="text-2xl">
            Bienvenido: {{ @Auth::user()->name }}
        </div>
        <div class="text-gray-500">
            <ul>
                <li class="list-item">
                    - Correo: {{ @Auth::user()->email }}
                </li>
                <li class="list-item">
                    - Autenticación de 2 pasos: 
                    @if (@Auth::user()->two_factor_secret != Null)<text class="text-success">Habilitada</text>
                    @else <text class="text-danger">Deshabilitada</text>
                    @endif
                </li>
                <li class="list-item">
                    - Ultima actualización de perfil: {{date('d/m/Y', strtotime(@Auth::user()->updated_at)) }}
                </li>
                <li class="list-item">
                    @if (@Auth::user()->updated_at < $limite) <text class="text-danger">No actualizas tu contraseña hace más de 90 días</text>
                    @else 
                    @endif 
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-1">
        fdsfs
    </div>
</div>
</div>

<div class="p-6 border-t border-gray-200 md:border-l">
    <div class="row">
    <div class="col-md-6">
        <div class="flex items-center">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-indigo-600"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            <div class="ml-4 text-lg text-indigo-600 leading-7 font-semibold">
                Preguntas y respuestas del Chatbot
            </div>
        </div>
        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
                Puedes revisar y editar las diferentes preguntas a las que responde el chatbot, además de añadir nuevas. 
            </div>
        </div>
    </div>
    <div class="col-md-6" style="padding-left:35px;">
        <ul class="mt-2 text-sm text-gray-500">
            <br>
            <li>
                - Preguntas activas:
            </li>
            <li class="list-item">
                - Preguntas inactivas:
            </li>
            <li class="list-item">
                - Finalizan en los próximos 7 días:
            </li>
        </ul>
    </div>
</div>
</div>

    


<div class="grid border-t grid-cols-1 md:grid-cols-2">
    <div class="p-6 border-gray-200 md:border-l">
        <div class="flex items-center">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-indigo-600"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            <div class="ml-4 text-lg text-indigo-600 leading-7 font-semibold">
                <a href="">Preguntas sugeridas por los estudiantes</a>
            </div>
        </div>
        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
                Revisa las preguntas que los estudiantes han sugerido para agregar al sistema. Puedes agregarlas o eliminarlas.
            </div>
            <ul class="mt-2 text-sm text-gray-500">
                <li>
                    - Preguntas sugeridas:
                </li>
                <li class="list-item">
                    - Ultima sugerencia realizada por 
                </li>
            </ul>
        </div>
    </div>
    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
        <div class="flex items-center">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-indigo-600"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <div class="ml-4 text-lg text-indigo-600 leading-7 font-semibold">
                <a href="">Comentarios recibidos de los estudiantes</a>
            </div>
        </div>
        <div class="ml-12">
            <div class="mt-2 text-sm text-gray-500">
                Revisa los diferentes comentarios que han escrito los estudiantes que han interactuado con el chatbot.
            </div>
            <ul class="mt-2 text-sm text-gray-500">
                <li>
                    Ultimo comentario recibido el  
                </li>
            </ul>
        </div>
    </div>
</div>

    <div class="p-6 border-t border-gray-200 md:border-l">
        <div class="ml-12">
            <div class="text-sm text-gray-500">
                ¿Necesitas ayuda? Puedes revisar diferentes tutoriales.
            </div>
        </div>
    </div>
</div>
