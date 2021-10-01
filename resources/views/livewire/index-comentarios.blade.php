<div class="container">

  <div>
    @if (session()->has('message'))
      <div class="alert alert-success">
        {{ session('message') }}
      </div>
    @endif
    </div>
    
  <div id="accordion">
    @foreach ($comentarios as $comentario)
      <div class="card">
        <div class="card-header style="background-color:#bcbcbc"
        @if ($comentario->tipo == 'positivo') style="background-color:#89E380"
        @elseif ($comentario->tipo == 'neutral') style="background-color:#bcbcbc"
        @else style="background-color:#dc6767" @endif"
        id="heading{{$comentario->id}}">
          <h5 class="mb-0">
            <button class="btn btn-link text-black" data-toggle="collapse" data-target="#collapse{{$comentario->id}}" aria-expanded="true" aria-controls="collapse{{$comentario->id}}">
              Comentario: #{{$comentario->id}} ({{$comentario->nombre}})
            </button>
            <div class="float-right">
              <button class="btn btn-danger btn-sm" wire:click="delete({{ $comentario->id }})">
                <i class="material-icons">delete_outline</i>
              </button>
            </div>
          </h5>
        </div>
        <div id="collapse{{$comentario->id}}" class="collapse show" aria-labelledby="heading{{$comentario->id}}" data-parent="#accordion">
          <div class="card-body">
            "{{$comentario->comentarios_y_sugerencias}}"
            <br><div class="float-right">
              Recibido el: {{date('d/m/Y h:i', strtotime($comentario->created_at))}}
            </div>
          </div>
        </div>
      </div>
    @endforeach
    {{ $comentarios->links() }}
  </div>
</div>