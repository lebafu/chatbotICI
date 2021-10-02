<div>
  <div class="panel-body">

    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <h4 class="text-center">
      ¿Cómo calificarías tu experiencia chateando con ICIBOT?
    </h4>

    <div class="row">
      <div class="col-md-12">
        <div class="input-group">
          <div class="input-group-btn btn-block" data-toggle="tipo">
            <div class="row">  
              <div class="col-md-4">
                <label class="btn btn-success btn-block active">
                  <input wire:model="tipo" name="tipo" type="radio" value="positivo" checked> 
                  <i class="material-icons">thumb_up_alt</i>  Positivo
                </label>
              </div>
              <div class="col-md-4">
                <label class="btn btn-secondary btn-block">
                  <input wire:model="tipo" name="tipo" type="radio"  value="neutral"> 
                  <i class="material-icons">remove_circle_outline</i>  Neutral
                </label>
              </div>
              <div class="col-md-4">
                <label class="btn btn-danger btn-block">
                  <input wire:model="tipo" name="tipo" type="radio" value="negativo"> 
                  <i class="material-icons">thumb_down_alt</i>  Negativo
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
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
          <textarea wire:model="comentarios_y_sugerencias" type="text" rows="3" class="form-control" name="comentarios" placeholder="Ingrese su comentario o sugerencia"></textarea>
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


