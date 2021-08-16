<div class="container">

  <div>
    @if (session()->has('message'))
      <div class="alert alert-success">
        {{ session('message') }}
      </div>
    @endif
    </div>
    
    <table class="table table-bordered">
        <tr>
            <th>Preguntas</th>
            <th>Respuesta</th>
            <th width="250px">Action</th>
        </tr>
      </table>
  <div id="accordion">
    @foreach ($archivoPregs as $archivoPreg)
      <div class="card">
        <div class="card-header" id="heading{{$archivoPreg->id}}">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$archivoPreg->id}}" aria-expanded="true" aria-controls="collapse{{$archivoPreg->id}}">
             {{$archivoPreg->nombre}}
            </button>
            <div class="float-right">
              @if($archivoPreg->habilitada==0)
                <button class="btn btn-danger btn-sm" wire:click="habilitada({{ $archivoPreg->id }})">Deshabilitada</button>
              @else
              <button class="btn btn-success btn-sm" wire:click="habilitada({{ $archivoPreg->id}})">Habilitada</button>
            @endif
            </div>
          </h5>
        </div>
        <div id="collapse{{$archivoPreg->id}}" class="collapse show" aria-labelledby="heading{{$archivoPreg->id}}" data-parent="#accordion">
          <div class="card-body">
            <br><div class="float-right">
              Fecha creación: {{date('d/m/Y h:m', strtotime($archivoPreg->updated_at))}}
            </div>
          </div>
        </div>
      </div>
    @endforeach
    {{ $archivoPregs->links() }}
  </div>
</div>
