<x-app-layout>

   <style>
        input[type="text"] {
           border:none; /* Get rid of the browser's styling */
           border-bottom:1px solid black; /* Add your own border */
           padding-bottom: 0px;
        }

        .row-bottom-margin {margin-bottom: -15px;  }

    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Preguntas del sistema Chatbot') }}
        </h2>
    </x-slot><br>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div id="accordion">
              <div class="card">
                <div class="card-header" id="headingOne">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        <i class="material-icons">question_answer</i>
                          Agregar nueva pregunta al Chatbot
                    </button>
                  </h5>
                </div>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                  <div class="card-body">
                        @livewire('crear-pregunta')
                  </div>
                </div>
              </div>
            </div>
        </div> 
        @livewire('index-preguntas')   
    </div>
</div>

</x-app-layout>




