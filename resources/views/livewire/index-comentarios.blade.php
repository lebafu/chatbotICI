<div class="container-fluid" style="padding-right: 30px; padding-left: 30px; ;">

  <div>
    @if (session()->has('message'))
      <div class="alert alert-success">
        {{ session('message') }}
      </div>
    @endif
    </div>


    <div class="row">
      <div class="col-md-3">

        <div id="accordion" role="tablist" aria-multiselectable="true" class="o-accordion">
  <div class="card multi">
    <div class="card-header border-bottom border-secondary" style="background-color:#E5E8E8" role="tab" id="heading1">
      <h5 class="mb-0">
        <div class="row">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="false" aria-controls="collapse1">
                <strong>  Filtro</strong>
                </a>
        </div>
      </h5>
    </div>
    <div id="collapse1" class="collapse show" role="tabpanel" aria-labelledby="heading1">
      <div class="card-block">
         <div><input wire:model="filtro" name="filtro" type="radio" value="todos"> Mostrar todos</div>
                  <div><input wire:model="filtro" name="filtro" type="radio" value="positivo"> Solo positivos</div>
                  <div><input wire:model="filtro" name="filtro" type="radio" value="neutral"> Solo neutros</div>
                  <div><input wire:model="filtro" name="filtro" type="radio" value="negativo"> Solo negativos</div>
      </div>
    </div>
    <div class="card-header border-bottom border-secondary" style="background-color:#E5E8E8" role="tab" id="heading2">
      <h5 class="mb-0">
        <div class="row">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" aria-controls="collapse2">
                <strong>  Orden</strong>
                </a>
        </div>
      </h5>
    </div>
    <div id="collapse2" class="collapse show" role="tabpanel" aria-labelledby="heading2">
      <div class="card-block">
<div><input wire:model="orden" name="orden" type="radio" value="nuevo"> Más nuevo primero</div>
        <div><input wire:model="orden" name="orden" type="radio" value="antiguo"> Más antiguo primero</div> 
                  <div><input wire:model="orden" name="orden" type="radio" value="abc"> Ordenar por nombre</div>
        
                  
                
      </div>
    </div>
    <div class="card-header border-bottom border-secondary" style="background-color:#E5E8E8" role="tab" id="heading3">
      <h5 class="mb-0">
        <div class="row">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
                <strong>  Paginación</strong>
                </a>
        </div>
      </h5>
    </div>
    <div id="collapse3" class="collapse show" role="tabpanel" aria-labelledby="heading3">
      <div class="card-block">
      <form role="form" class="form-inline">
      <div class="form-group">
            <label for="cant_pagina">Elementos por página:</label>
            <input wire:model="cant_pagina" type="number"  min="1" max="99" style="width: 4em;" class="form-control ml-sm-3">
          </div>
          </form> 
    
      </div>
    </div>
  </div>
</div>

    

    

      </div>
      
    

 <div class="col-md-9">     
  <div class="card-columns" style="padding-left:0px;padding-right:0px"> 
  @foreach ($comentarios as $comentario)   
    <div class="card">
      <div class="card-body style="background-color:#bcbcbc"
        @if ($comentario->tipo == 'positivo') style="background-color:#89E380"
        @elseif ($comentario->tipo == 'neutral') style="background-color:#bcbcbc"
        @else style="background-color:#dc6767" @endif">
          <div class="row">
            <div class="col-md-2">
              <i class="material-icons" style="color:rgb(240,240,240);font-size: 30px">
              @if ($comentario->tipo == 'positivo') thumb_up_alt
        @elseif ($comentario->tipo == 'neutral') remove_circle_outline
        @else  thumb_down_alt @endif
            </i>
            </div>
          <div class="col-md-8">
            <div class="card-title text-center">
          <strong>#{{$comentario->id}}: {{$comentario->nombre}}</strong>
        </div>
          </div>
          <div class="col-md-2 text-center">
          <button class="btn btn-danger btn-sm" style="height:30px;margin-right: 2px;" wire:click="delete({{ $comentario->id }})">
                <i class="material-icons" style="font-size: 20px">delete_outline</i>
              </button>
          </div>
        </div>
      
        <p class="card-text text-center" style="padding-left:0px;padding-right:0px">"{{$comentario->comentarios_y_sugerencias}}"<br>
          <em style="font-size: 13px">(Recibido el: {{date('d/m/Y h:i', strtotime($comentario->created_at)) }})</em>
        </p>
      </div>
    </div>
    @endforeach
  </div>
{{ $comentarios->links() }}
  </div>

</div>
    
</div>