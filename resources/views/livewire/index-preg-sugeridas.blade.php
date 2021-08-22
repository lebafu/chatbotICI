<div class="container">

  <div>
    @if (session()->has('message'))
      <div class="alert alert-success">
        {{ session('message') }}
      </div>
    @endif
    </div>
    
  <div id="accordion">
    @foreach ($PregSugeridas as $PregSugerida)
      <div class="card">
        <div class="card-header" id="heading{{$PregSugerida->id}}">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$PregSugerida->id}}" aria-expanded="true" aria-controls="collapse{{$PregSugerida->id}}">
              #{{$PregSugerida->id}} : {{$PregSugerida->pregunta_sin_respuesta}}  
            </button>
            <div class="float-right">
              <button class="btn btn-danger btn-sm" wire:click="delete({{ $PregSugerida->id }})">X</button>
            </div>
          </h5>
          <h2>
            Sugerida por: {{$PregSugerida->nombre}} ({{date('d/m/Y h:m', strtotime($PregSugerida->created_at))}})
          </h2>
        </div>
        <div id="collapse{{$PregSugerida->id}}" class="collapse show" aria-labelledby="heading{{$PregSugerida->id}}" data-parent="#accordion">
          <div class="card-body">
            @livewire('agregar-pregsugerida', ['PregSugerida' => $PregSugerida])
          </div>
        </div>
      </div>
    @endforeach
    {{ $PregSugeridas->links() }}
  </div>
</div>
