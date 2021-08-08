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
      <div class="form-group col-md-6">
            <label for="Nombre"><b>Nombre (requerido):</b></label>
            <input wire:model="nombre.0" type="text" class="form-control" placeholder="Ingrese su nombre">
          </div>
          <div class="form-group col-md-6">
            <label for="Email"><b>Correo institucional (requerido):</b></label>
            <input wire:model="email.0" type="email" class="form-control" placeholder="Ingrese su correo institucional">
            @error('email')
              <p class="text-danger">{{ $message }}</p>
          @enderror
          </div>   
    </div>
    <div class="row">
      <div class="form-group col-md-10">
            <label for="preguntas"><b>Preguntas que desee agregar (requerido):</b></label>
            <input wire:model="pregunta_sin_respuesta.0" type="text" class="form-control" name="preguntas"></textarea>
      </div>
      <div class="form-group col-md-2">
            <button class="btn text-white btn-info btn-sm" wire:click="add({{$i}})">Añadir</button>
      </div>
    </div>

    @foreach($inputs as $key => $value)
                <div class="row">
                  <div class="form-group col-md-10">
                      <input wire:model="pregunta_sin_respuesta.{{ $value }}" type="text" rows="4" class="form-control" name="preguntas"></input>
                  </div>
                  <div class="form-group col-md-2">
                      <button class="btn btn-danger btn-sm">X</button>
                  </div>
                </div>
        @endforeach

    <div class="form-row justify-content-center">
              <button wire:click="store()" class="btn btn-success center">Guardar</button>
    </div>  
  </div>
</div>