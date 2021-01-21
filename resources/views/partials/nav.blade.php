<nav style="background-color: rgb(0, 85, 169)" class="navbar navbar-expand-lg navbar-dark ">
  <a class="navbar-brand" href="{{ url('/') }}"><i class="material-icons" >home</i></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
      <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <!-- Lado Izquierdo de Navbar -->
      <ul class="navbar-nav mr-auto">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav navbar-nav">
              <a class="nav-link" href="{{ route('intents.nlu_index')}}">Intenciones</a>
            </li>
            <li class="nav navbar-nav">
              <a class="nav-link" href="{{ route('qna.index')}}">Q&A</a>
            </li>
          </ul>
        </div>
      </ul>

      <!-- Lado derecho de Navbar -->
      <ul class="navbar-nav ml-auto">
          <!-- Opciones de autenticacion y logeo -->
          <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  Nombre usuario <span class="caret"></span>
              </a>
          </li>
      </ul>
  </div>
</nav>
