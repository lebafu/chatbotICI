<div class="container">

  <div>
    @if (session()->has('message'))
      <div class="alert alert-success">
        {{ session('message') }}
      </div>
    @endif
    </div>
    
  <div id="accordion">
    @foreach ($archivoPregs as $archivoPreg)
      <div class="card">
        <div class="card-header" id="heading{{$archivoPreg->id}}">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$archivoPreg->id}}" aria-expanded="true" aria-controls="collapse{{$archivoPreg->id}}">
             {{$archivoPreg->nombre}}
            </button>
            <div class="float-right">
              <button class="btn btn-danger btn-sm" wire:click="delete({{ $archivoPreg->id }})">X</button>
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
