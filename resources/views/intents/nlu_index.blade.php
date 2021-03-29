<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
     <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Todas las intenciones de Aprendizaje del Lenguaje Natural</h2>
            </div>
            <div class="pull-right">
                
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>nombre</th>
            <th>Expresión equivalente para nombre</th>
            <th>Action</th>
        </tr>
        @foreach ($datos as $dato)
        <tr>
            <td>{{ $dato->id}}</td>
            <td>{{ $dato->nombre}}</td>
            <td>{{ $dato->respuestas}}</td>
            <td>
               
    
                    <a class="btn btn-primary" href="{{ route('intents.nlu_edit',$dato->id) }}">Edit</a>
   
                
            </td>
        </tr>
        @endforeach
    </table>
            </div>
        </div>
    </div>
</x-app-layout>
   