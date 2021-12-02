@if($cantidad_preguntas>0)
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Preguntas sugeridas por los estudiantes') }}
        </h2>
      
    </x-slot>

<div class="container">
  <br>

  <div>
    @if (session()->has('message'))
      <div class="alert alert-success">
        {{ session('message') }}
      </div>
    @endif
    </div>


<form role="form" class="form-inline">
<div class="col-md-12"> 
  <div class="pull-left">
  <div class="form-group">
          <label for="orden"><b>Orden:</b></label>              
            <select wire:model="orden" name="orden" style="margin-left: 10px;">
              <option value="antiguo">Más antiguas primero</option>
              <option value="nuevo">Más nuevas primero</option>
            </select>
          </div>
</div>
<div class="pull-right">
<div class="form-group">
            <label for="cant_pagina"><b>Elementos por página:</b></label>
            <input wire:model="cant_pagina" type="number" min="1" max="99" style="width: 4em;" class="form-control ml-sm-3">
          </div>
</div>
</div>
</form><br>

       
            


      

<div id="accordion" role="tablist" aria-multiselectable="true" class="o-accordion">
  <div class="card multi">
    @foreach ($PregSugeridas as $PregSugerida)
    <div class="card-header border-bottom border-secondary" style="background-color:#E5E8E8" role="tab" id="heading{{$PregSugerida->id}}">
      <h5 class="mb-0">
        <div class="row">
          <div class="col-md-11">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$PregSugerida->id}}" aria-expanded="false" aria-controls="collapse{{$PregSugerida->id}}">
                <strong> #{{$PregSugerida->id}} : {{$PregSugerida->pregunta_sin_respuesta}} </strong>
                <br>
                <h2>
            <em style="font-size: 14px"> Sugerida por: {{$PregSugerida->nombre}} ({{date('d/m/Y h:i', strtotime($PregSugerida->created_at))}})</em>
          </h2></a>
          </div>
          <div class="col-md-1">
              <div class="float-right">
                <button class="btn btn-danger btn-sm" wire:click="delete({{ $PregSugerida->id }})">
                <i class="material-icons">delete_outline</i>
              </button>
              </div>
              </div>
        </div>
      </h5>
      
    </div>
    <div id="collapse{{$PregSugerida->id}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$PregSugerida->id}}">
      <div class="card-block">
         @livewire('agregar-pregsugerida', ['PregSugerida' => $PregSugerida], key($PregSugerida->id))
      </div>
    </div>
    @endforeach
  </div>
</div>

    {{ $PregSugeridas->links() }}
</div>
@else
        <div class="row justify-content-center">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="false" aria-controls="collapse1">
                        <strong>No existen nuevas preguntas sugeridas al sistema</strong>
                        </a>
          </div>
@endif
