<div>
  <div class="panel-body">

    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <div>
        @if (session()->has('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
            <label for="Nombre"><b>Nombre (requerido):</b></label>
            <input wire:model="nombre" type="text" class="form-control" placeholder="Ingrese su nombre">
          </div>
          <div class="form-group col-md-6">
            <label for="Email"><b>Correo institucional (requerido):</b></label>
            <input wire:model="email" type="email" class="form-control" placeholder="Ingrese su correo institucional">
            @error('email')
              <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>   
    </div>
    <div class="row">
      <div class="form-group col-md-11">
            <label for="preguntas"><b>Preguntas que desee agregar (requerido):</b></label>
            <input wire:model="pregunta_sin_respuesta.0" type="text" class="form-control" name="preguntas"></input>
      </div>
      <div class="form-group col-md-1">
            @if($i < 10)
                <button class="btn text-white btn-info btn-sm" wire:click="add({{$i}})">Añadir</button>
            @else
                <button class="btn text-white btn-info btn-sm" wire:click="max()">Añadir</button>
            @endif
      </div>
    </div>

    @foreach($inputs as $key => $value)
                <div class="row">
                  <div class="form-group col-md-11">
                      <input wire:model="pregunta_sin_respuesta.{{ $value }}" type="text" rows="4" class="form-control" name="preguntas"></input>
                      
                  </div>
                  <div class="form-group col-md-1">
                      <button class="btn btn-danger btn-sm" wire:click="remove({{$key}})">X</button>
                  </div>
                </div>
    @endforeach

    @error('pregunta_sin_respuesta.*')
        <p class="text-danger">{{ $message }}</p>
    @enderror

    <div class="form-row justify-content-center">
        @if(strlen($nombre) > 0 && strlen($email) > 0)
            <button wire:click="store()" class="btn btn-success center">Guardar</button>
        @else
            <button wire:click="store()" class="btn btn-success center" disabled>Guardar</button>
        @endif
    </div>  
  </div>
</div>