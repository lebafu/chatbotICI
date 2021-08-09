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
    <div class="form-group">
          <label for="comentarios"><b>Comentarios o sugerencias (mínimo 5 caracteres):</b></label>
          <textarea wire:model="comentarios_y_sugerencias" type="text" rows="4" class="form-control" name="comentarios" placeholder="Ingrese su comentario o sugerencia"></textarea>
          <p class="text-right">{{ strlen($comentarios_y_sugerencias) }} / 250 </p>
          @if(strlen($comentarios_y_sugerencias) > 250)
              <p class="text-danger">No puedes exceder de 250 caracteres</p>
          @endif

    </div>
    <div class="form-row justify-content-center">
          @if(strlen($nombre) > 0 && strlen($email) > 0 && strlen($comentarios_y_sugerencias) >= 5 && strlen($comentarios_y_sugerencias) <= 250)
              <button wire:click="store()" class="btn btn-success center">Guardar</button>
          @else
              <button wire:click="store()" class="btn btn-success center" disabled>Guardar</button>
          @endif
    </div>  
  </div>
</div>


