<div class="container-fluid" style="padding-left:15px;padding-right:15px">

  <div>
    @if (session()->has('message'))
      <div class="alert alert-success">
        {{ session('message') }}
      </div>
    @endif
    </div>

    <div class="row">
      <div class="col-md-3">

<div class="card">
                        <div class="card-header" style="background-color:#E5E8E8">
                            <strong>  Filtro</strong>
                        </div>
                        <div class="card-body">

<b>Filtrar por estado:</b>
         <div><input wire:model="estado" name="estado" type="radio" value="todos"> Mostrar todos</div>
                  <div><input wire:model="estado" name="estado" type="radio" value=1> Solo Habilitadas</div>
                  <div><input wire:model="estado" name="estado" type="radio" value=0> Solo Deshabilitadas</div>
                  <div><input wire:model="estado" name="estado" type="radio" value="filtro_vence"> Vencen pronto (7 días)</div>

<b>Filtrar por categoría:</b>
        <div><input wire:model="filtro_cat" name="filtro_cat" type="radio" value="todas"> Todas las categorías</div>
        @foreach($categorias as $categoria)
                <div><input wire:model="filtro_cat" name="filtro_cat" type="radio" value="{{$categoria->id}}"> {{$categoria->nombre}}</div>
              @endforeach
                            
                        </div>
                    </div>
        


    </div>
  

    

    

    
      
    

 <div class="col-md-9">  


  <form role="form" class="form-inline">
<div class="col-md-12"> 
  <div class="pull-left">
  <div class="form-group">
          <label for="orden"><b>Orden:</b></label>              
            <select wire:model="orden" name="orden" style="margin-left: 10px;">
              <option value="asc">Más antiguas primero</option>
              <option value="desc">Más nuevas primero</option>
            </select>
          </div>
</div>
<div class="pull-right">
<div class="form-group">
            <label for="cant_pagina"><b>Elementos por página:</b></label>
            <input wire:model="cant_pagina" type="number" min="1" max="99" style="width: 4em;" class="form-control ml-sm-3 mr-sm-3">
          </div>
</div>
</div>
</form><br>


<div id="accordion" role="tablist" aria-multiselectable="true" class="o-accordion">
  <div class="card multi">
    @foreach ($archivoPregs as $archivoPreg)
    <div class="card-header border-bottom border-secondary" style="background-color:#E5E8E8" role="tab" id="heading{{$archivoPreg->id}}">
      <h5 class="mb-0">
        <div class="row">
          <div class="col-md-11" style="padding-right:35px">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$archivoPreg->id}}" aria-expanded="false" aria-controls="collapse{{$archivoPreg->id}}">
                {{$archivoPreg->Question[0]->pregunta }}
                </a>
          </div>
          <div class="col-md-1" style="padding-right:10px">
              <div class="float-right">
                <button class="btn btn-danger btn-sm" wire:click="habilitada({{ $archivoPreg->id}})">
                <i class="material-icons" style="font-size: 15px">comments_disabled</i> Deshabilitar
              </button>
              </div>
              </div>
        </div>
      </h5>
    </div>
    <div id="collapse{{$archivoPreg->id}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$archivoPreg->id}}">
      <div class="card-block">
        @livewire('editar-pregunta', ['archivoPreg' => $archivoPreg], key($archivoPreg->id))
      </div>
    </div>
    @endforeach
  </div>
</div>

 {{ $archivoPregs->links() }}
</div>
</div>

