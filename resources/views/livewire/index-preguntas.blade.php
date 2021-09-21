<div class="container">

  <div>
    @if (session()->has('message'))
      <div class="alert alert-success">
        {{ session('message') }}
      </div>
    @endif
    </div>

  <div class="float-right">
    <button class="btn btn-danger btn-sm" wire:click="vista_des()">Ver deshabilitadas</button>
  </div>

  <div id="accordion">
    @foreach ($archivoPregs as $archivoPreg)
      <div class="card">
        <div class="card-header" id="heading{{$archivoPreg->id}}">
          <h5 class="mb-0">
            <div class="row">
            <div class="col-md-11">
              <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$archivoPreg->id}}" aria-expanded="true" aria-controls="collapse{{$archivoPreg->id}}">
               {{$archivoPreg->nombre}}
              </button>
            </div>
            <div class="col-md-1">
              <div class="float-right">
                <button class="btn btn-danger btn-sm" wire:click="habilitada({{ $archivoPreg->id}})">Deshabilitar</button>
              </div>
              </div>
            </div>
          </h5>
        </div>
        <div id="collapse{{$archivoPreg->id}}" class="collapse show" aria-labelledby="heading{{$archivoPreg->id}}" data-parent="#accordion">
          <div class="card-body">
            <br><div class="float-right">
              @livewire('editar-pregunta', ['archivoPreg' => $archivoPreg], key($archivoPreg->id))
              Fecha creación: {{date('d/m/Y h:m', strtotime($archivoPreg->updated_at))}}
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
 {{ $archivoPregs->links() }}
</div>
