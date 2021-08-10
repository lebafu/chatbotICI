<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Preguntas del sistema Chatbot') }}
        </h2>
    </x-slot>
   
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

        <div class="col-md-10">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Preguntas</th>
                    <th>Respuesta</th>
                    <th width="250px">Action</th>
                </tr>
                @foreach ($datos as $dato)
                <tr>
                    <td>{{ $dato->id}}</td>
                    <td>{{ $dato->pregunta}}</td>
                    <td>{{ $dato->nombre}}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('qna.index',$dato->id) }}"><span  class="fas fa-eye fa-xs" style="color:black"></span></a>
                    </td>
                </tr>
                @endforeach
            </table>

            {{$datos->links()  }}
        </div>
    </div>

</x-app-layout>




