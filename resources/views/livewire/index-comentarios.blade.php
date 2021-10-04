<div class="container">

  <div>
    @if (session()->has('message'))
      <div class="alert alert-success">
        {{ session('message') }}
      </div>
    @endif
    </div>


    <div class="row">
      
      
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
          <button class="btn btn-danger btn-sm" style="height:30px" wire:click="delete({{ $comentario->id }})">
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

  
</div>
    {{ $comentarios->links() }}
</div>