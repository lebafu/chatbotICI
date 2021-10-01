<div>
  <div class="panel-body">

    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('problema_con_parentesis'))
            <div class="alert alert-danger">
                {{ session('problema_con_parentesis') }}
            </div>
        @endif
    </div>    


{{ $categoria}}
{{$vence}}
{{$contexto}}
    <div class="form-row">
      <div class="form-group col-md-7">
          <div class="row row-bottom-margin">
            <div class="form-group col-md-10">
                  <label for="preguntas"><b>Preguntas que desee agregar (requerido):</b></label>
                  <input wire:model="pregunta.0" wire:keydown.enter="add({{$i}})" type="text" class="form-control" name="preguntas"></input>
            </div>
            <div class="form-group col-md-1">
                  <button class="btn text-white btn-info btn-sm" wire:click="add({{$i}})">Añadir</button>
            </div>
          </div>
          @foreach($inputs as $key => $value)
            <div class="row row-bottom-margin">
              <div class="form-group col-md-10">
                  <input wire:model="pregunta.{{ $value }}" wire:keydown.enter="add({{$i}})" type="text" class="form-control" name="preguntas"></input>
              </div>
              <div class="form-group col-md-1">
                  <button class="btn btn-danger btn-sm" wire:click="remove({{$key}})">X</button>
              </div>
            </div>
          @endforeach
          @error('pregunta.*')
              <p class="text-danger">{{ $message }}</p>
          @enderror
    </div>

    <div class="form-group col-md-5">
      <div class="row">
        <div class="form-group col-md-12">
          <label for="resp"><b>Respuesta (requerido):</b></label>
          <textarea wire:model="resp" name="resp" id="resp" type="text" rows="4" class="form-control" placeholder="Respuesta:"></textarea>
        </div>
      </div>

      <div class="row">
        <div class="form-group col-md-12">
          <label for="categoria"><b>Categoría:</b></label>              
            <select wire:model="categoria" name="categoria">
              @foreach($categorias as $cat)
                <option value='{{$cat->id}}'>{{$cat->nombre}}</option>
              @endforeach
              <option value="nueva">Agregar nueva categoría</option>
            </select>
        </div>
      </div>

      @if($categoria=='nueva')
        <div class="row">
          <div class="form-group col-md-12">           
          <input wire:model="nueva_cat" name="nueva_cat" id="nueva_cat" type="text" class="form-control" placeholder="Nombre de la nueva categoría (requerido)"></input>
          </div>
        </div>
      @endif

      <div class="row">
        <div class="form-group col-md-12">
          <label for="contexto"><b>Contexto:</b></label>              
            <select wire:model="contexto" name="contexto">
              <option value="global">Global: para todos los usuarios</option>
              <option value="regular">Regular: Solo alumnos en estado regular</option>
              <option value="egresado">Egresado: Solo alumnos egresados</option>
            </select>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-12">
          <label for="vence"><b>Fecha de caducidad:</b></label><br>
          <input wire:model="vence" type="checkbox" class="form-control"> Añadir fecha de caducidad
        </div>
      </div>  
      <div class="row">
        <div class="form-group col-md-12">
          @if($vence == 1)
            <input wire:model="fecha_caducacion" type="date" min="<?= date('Y-m-d'); ?>" id="fecha_caducacion" class="form-control"> 
          @else
            <input wire:model="fecha_caducacion" type="date" class="form-control" disabled=""> 
          @endif
        </div>
      </div>       
    </div> 
  </div>
    
    <div class="form-row justify-content-center">
          @if(strlen($resp) > 0 && (($vence==1 && $fecha_caducacion!=null) || ($vence!=1)))
              <button wire:click="store()" class="btn btn-success center">Guardar</button>
          @else
              <button wire:click="store()" class="btn btn-success center" disabled>Guardar</button>
          @endif
    </div>
</div>