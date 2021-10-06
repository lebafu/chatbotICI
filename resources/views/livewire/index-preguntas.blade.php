<div class="container" style="padding-left:0px;padding-right:0px">

  <div>
    @if (session()->has('message'))
      <div class="alert alert-success">
        {{ session('message') }}
      </div>
    @endif
    </div>

<div class="row">
<div class="col-md-12">
  <div class="float-right">
    <button class="btn btn-secondary btn-xl" wire:click="vista_des()">Ver deshabilitadas</button>
  </div>
</div>
</div><br>


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
        {{$archivoPreg->categorias->nombre}}
        @livewire('editar-pregunta', ['archivoPreg' => $archivoPreg], key($archivoPreg->id))
      </div>
    </div>
    @endforeach
  </div>
</div>

 {{ $archivoPregs->links() }}
</div>
