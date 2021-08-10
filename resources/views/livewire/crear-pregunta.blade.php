<div>
  <div class="panel-body">

    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <div class="form-row">
      <div class="form-group col-md-8">
          <div class="row">
            <div class="form-group col-md-7">
                  <label for="preguntas"><b>Preguntas que desee agregar (requerido):</b></label>
                  <input wire:model="pregunta_sin_respuesta.0" type="text" class="form-control" name="preguntas"></input>
            </div>
            <div class="form-group col-md-1">
                  <button class="btn text-white btn-info btn-sm" wire:click="add({{$i}})">Añadir</button>
            </div>
          </div>
          @foreach($inputs as $key => $value)
            <div class="row">
              <div class="form-group col-md-11">
                  <input wire:model="pregunta_sin_respuesta.{{ $value }}" type="text" rows="4" class="form-control" name="preguntas"></input>
              </div>
              <div class="form-group col-md-1">
                  <button class="btn btn-danger btn-sm">X</button>
              </div>
            </div>
          @endforeach
    </div>


    <div class="form-group col-md-4">
        <label for="Email"><b>Respuesta (requerido):</b></label>
            <input wire:model="nombre" type="text" class="form-control" placeholder="Respuesta:">
        </div>   
    </div>
    

    <div class="form-row justify-content-center">
        @if(strlen($nombre) > 0)
            <button wire:click="store()" class="btn btn-success center">Guardar</button>
        @else
            <button wire:click="store()" class="btn btn-success center" disabled>Guardar</button>
        @endif
    </div>  
  </div>
</div>