<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-jet-welcome />
            </div>
        </div>
    </div>
</x-app-layout>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Listado de Q&A</h2>
            </div>
            <div class="pull-right">
                <!- -->
            </div>
        </div>
    </div>

    <a class="btn btn-primary" href="{{route('qna.create')}}">Create</a>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
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
                <!--
   
                    -->
    
                    <a class="btn btn-primary" href="{{route('qna.edit',$dato->id)}}">Editar</a>
                    @if($dato->habilitada==1)
                    <a class="btn btn-danger" href="{{route('qna.habilitada',$dato->id)}}">Deshabilitar</a>
                    @else
                    <a class="btn btn-success" href="{{route('qna.habilitada',$dato->id)}}">Habilitar</a>
                    @endif
            </td>
        </tr>
        @endforeach
    </table>
  

{{$datos->links()  }}

@endsection
