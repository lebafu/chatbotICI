<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
  <div class="row justify-content-center">
    <div class="col-md-3 ">
      <center><img src="images/logo.png" class=" h-16 w-auto" /></center>
    </div>
    <div class="col-md-6">
      <center>
        <div class="text-2xl">Bienvenido: {{ @Auth::user()->name }}</div>
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
              @endif 
            </li>
          </ul>
        </div>
      </center>
    </div>
    <div class="col-md-3">
      <center>
        <br><a class="btn bg-indigo-600 text-white btn-xl" href="{{ route('profile.show') }}">Ajustes de cuenta</a>
      </center>
    </div>
  </div>
</div>

<div class="p-6 border-t border-gray-200 md:border-l">
  <div class="row">
    <div class="col-md-6">
      <div class="flex items-center">
        <i class="ml-2 material-icons text-indigo-600" style="font-size: 30px">question_answer</i>
        <div class="ml-2 text-lg text-indigo-600 leading-7 font-semibold">
          <a href="{{ route('qna_index') }}">Preguntas y respuestas del Chatbot</a>
        </div>
      </div>
      <div class="ml-12">
        <div class="mt-2 text-sm text-gray-500">
          Puedes revisar y editar las diferentes preguntas a las que responde el chatbot, además de añadir nuevas. 
        </div>
      </div>
    </div>
    <div class="col-md-6" style="padding-left:35px;">
      <ul class="mt-2 text-sm text-gray-500"><br>
        <li>
            - Preguntas activas: <text class="text-success"><strong> {{ $activas }} </strong></text>
        </li>
        <li class="list-item">
            - Preguntas inactivas: <text class="text-danger"><strong> {{ $inactivas }} </strong></text>
        </li>
        <li class="list-item">
            - Finalizan en los próximos siete días: <text class="text-warning"><strong> {{ $finalizan }} </strong></text>
        </li>
      </ul>
    </div>
  </div>
</div>

<div class="grid border-t grid-cols-1 md:grid-cols-2">
  <div class="p-6 border-gray-200 md:border-l">
    <div class="flex items-center">
      <i class="ml-2 material-icons text-indigo-600" style="font-size: 30px">person_pin</i>
      <div class="ml-2 text-lg text-indigo-600 leading-7 font-semibold">
        <a href="{{ route('index_preguntas_sugeridas') }}">Preguntas sugeridas por los estudiantes</a>
      </div>
    </div>
    <div class="ml-12">
      <div class="mt-2 text-sm text-gray-500">
        Revisa las preguntas que los estudiantes han sugerido para agregar al sistema. Puedes agregarlas o eliminarlas.
      </div>
      <ul class="mt-2 text-sm text-gray-500">
        <li>
          - Preguntas sugeridas: {{ $sugeridas }}
        </li>
        @if ($sugeridas > 0)
          <li class="list-item">
            - Ultima sugerencia realizada por <strong> {{ $ult_sugerida->nombre }}</strong>, con fecha <strong> {{date('d/m/Y', strtotime($ult_sugerida->created_at)) }} </strong>
          </li>
        @endif
      </ul>
    </div>
  </div>
  <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
    <div class="flex items-center">
      <i class="ml-2 material-icons text-indigo-600" style="font-size: 30px">rate_review</i>
      <div class="ml-2 text-lg text-indigo-600 leading-7 font-semibold">
        <a href="{{ route('index_comentarios') }}">Comentarios recibidos de los estudiantes</a>
      </div>
    </div>
    <div class="ml-12">
      <div class="mt-2 text-sm text-gray-500">
        Revisa los diferentes comentarios que han escrito los estudiantes que han interactuado con el chatbot.
      </div>
      <ul class="mt-2 text-sm text-gray-500">
        <li>
            - Comentarios recibidos: {{ $comentarios }}  
        </li>
        @if ($comentarios > 0)
          <li>
            - Ultimo comentario realizado por <strong> {{ $ult_comentario->nombre }}</strong>, con fecha <strong> {{date('d/m/Y', strtotime($ult_comentario->created_at)) }} </strong>  
          </li>
        @endif
      </ul>
    </div>
  </div>
</div>

<div class="p-6 border-t border-gray-200 md:border-l">
  <div class="flex items-center">
    <i class="ml-2 text-indigo-600 material-icons" style="font-size: 30px">arrow_circle_right</i>
    <div class="ml-2 text-lg text-indigo-600 leading-7 font-semibold">
      <a href="">¿Necesitas ayuda? Puedes revisar diferentes tutoriales.</a>
    </div>
  </div>
</div>