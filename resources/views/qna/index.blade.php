@extends('layouts.app')
 
@section('content')
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
© 2020 GitHub, Inc.