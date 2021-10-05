<div class="container">
  <br>

  <div>
    @if (session()->has('message'))
      <div class="alert alert-success">
        {{ session('message') }}
      </div>
    @endif
    </div>

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

