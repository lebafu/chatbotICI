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

    <div class="form-row">
      <div class="form-group col-md-7">
        <div class="row row-bottom-margin">
            <label for="preguntas"><b>Preguntas que desee agregar (requerido):</b></label>
            <div class="form-group col-md-10">
              <input wire:model="pregunta.0"  wire:keydown.enter="add({{$i}})" type="text" class="form-control" name="preguntas"></input>
            </div>
            <div class="form-group col-md-1">
              <button class="btn text-white btn-info btn-sm" wire:click="add({{$i}})">✚</button>
            </div>
        </div>
        @foreach($inputs as $key => $value)
          <div class="row row-bottom-margin">
            <div class="form-group col-md-10">
              <input wire:model="pregunta.{{ $value }}"  wire:keydown.enter="add({{$i}})" type="text" class="form-control" name="preguntas"></input>
            </div>
            <div class="form-group col-md-1">
                <button class="btn btn-danger btn-sm" wire:click="remove({{$key}})">✕</button>
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
            <label for="resp"><b>Respuesta (requerido):</b></label><br>
            <input wire:model="respuesta_existente" type="checkbox" class="form-control">Añadir a respuesta existente <br>
            @if($respuesta_existente==null)
              <textarea wire:model="resp" name="resp" id="resp" type="text" rows="4" class="form-control" placeholder="Respuesta:"></textarea>
            @else
              <select wire:model="resp2">
                @foreach($answers as $answer)
                  @if($answer->nombre=="#!builtin_image-euONpC")
                    <option value="#!builtin_image-euONpC">Mapa de Salas</option>
                  @else
                    <option value="{{$answer->id}}">{{$answer->nombre}}</option>
                  @endif
                @endforeach
              </select>
            @endif     
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
              <input wire:model="fecha_caducacion" type="date" min="<?= date('Y-m-d'); ?>" class="form-control"> 
            @else
              <input wire:model="fecha_caducacion" type="date" class="form-control" disabled=""> 
            @endif
          </div>
        </div>       
      </div>
    </div>
    
    <div class="form-row justify-content-center">
          @if((strlen($resp)>0 && $respuesta_existente==0) && $i>1 && $pregunta[0]!=null && (($vence==1 && $fecha_caducacion!=null) || ($vence!=1)))
              <button wire:click="store()" class="btn btn-success center">Guardar</button>
          @elseif((strlen($resp2)>0 && $respuesta_existente==1) && $i>1 && $pregunta[0]!=null && (($vence==1 && $fecha_caducacion!=null) || ($vence!=1)))
              <button wire:click="store()" class="btn btn-success center">Guardar</button>
           @else
               <button wire:click="store()" class="btn btn-success center" disabled>Guardar</button>
          @endif
    </div>
  </div>
</div>