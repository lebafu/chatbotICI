<div>
  <div class="panel-body">
    <form id="uploads" enctype="multipart/form-data" wire:submit.prevent="update">  
      <div>
        @if (session()->has('message'))
          <div class="alert alert-success">
            {{ session('message') }}
          </div>
        @elseif( session()->has('message_delete'))
          <div class="alert alert-danger">
            {{ session('message_delete') }}
          </div>
        @endif
      </div>

      <div class="form-row">
        <div class="form-group col-md-7">
          <div class="row row-bottom-margin">
            <input id="id" type="hidden" class="form-control" name="id" wire:model="selected_id" required autocomplete="nombre" autofocus readonly></input>
            <label for="preguntas"><b>Preguntas que desee agregar (requerido):</b></label>
            <div class="form-group col-md-10">
              <input wire:model="pregunta.0" type="text" class="form-control" name="preguntas" disabled></input>
            </div>
            <div class="form-group col-md-1">
              <button class="btn text-white btn-info btn-sm" wire:click="add({{$i}})">✚</button>
            </div>
          </div>
          @foreach($inputs as $key => $value)
            <div class="row row-bottom-margin">
              <div class="form-group col-md-10">
                <input wire:model="pregunta.{{ $value }}" wire:keydown.enter="add({{$i}})" type="text" class="form-control" name="preguntas"></input>
              </div>
              <div class="form-group col-md-1">
                <button class="btn btn-danger btn-sm" wire:click="remove({{$key}})">✕</button>
              </div>
            </div>
            <input wire:model="pregunta_copy.{{ $value }}" type="hidden" class="form-control" name="pregunta_copy"></input>
          @endforeach
          @error('pregunta.*')
            <p class="text-danger">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group col-md-5">
          @if($es_archivo_flow==false)
            @if($pos==0)
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="Respuesta"><b>Respuesta (requerido):</b></label>
                  <textarea wire:model="resp" type="text" rows="4" class="form-control" placeholder="Respuesta:"></textarea>
                </div>
              </div>
            @elseif($pos==1)
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="Respuesta"><b>Respuesta (requerido):</b></label>
                  <textarea wire:model="resp" type="text" rows="4" class="form-control" placeholder="Respuesta:" disabled></textarea>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="img" class="negrita">La imagen seleccionada fue:</label>
                  <input wire:model="name_image" readonly="readonly" hidden="hidden">
                  <img src="images/bp/{{$name_image}}">
                </div>
              </div>                
              <div class="row">
                <div class="form-group col-md-12">
                  <label>Cambiar Imagen: </label>
                  <input type="file" wire:model="image_nueva" class="form-control"/>
                  <div class='text-danger'>{{$errors->first('image_nueva')}}</div>
                </div>
              </div>
            @endif
          @endif
          @if($es_archivo_flow!=false)
            <div class="row">
              <div class="form-group col-md-12">
                <label for="Respuesta"><b>Respuesta (requerido):</b></label>
                <textarea wire:model="resp" type="text" rows="4" class="form-control" placeholder="Respuesta:" disabled></textarea>
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

      @if($es_archivo_flow!=false)
        @for($i=0;$i<$tam_array_builtins_texts_unique;$i++)
          <input type="hidden" class="form-control" wire:model="builtins_texts_index_unique.{{$i}}" required>
        @endfor
        <b>Nota: El término \n representa el salto de línea en el chatbot, si lo cree necesario en la oración no lo elimine.</b>
        @foreach($todo_ordenado as $key => $value)
          @if($key>=2)
            @if($todo_ordenado[$key-1]=="builtin_image")
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="img" class="negrita">La imagen seleccionada fue:Malla {{$nombres_imagenes[$key]}}</label><br>
                  <input type="hidden" class="form-control" wire:model="nombres_imagenes.{{ $key }}" required><br>
                  <img src="images/bp/{{$todo_ordenado[$key]}}" width="50%" height="50%"><br>
                  <label for="img" class="negrita">Cambiar la imagen:</label><br>
                  <input type="text" wire:model="todo_ordenado_copy.{{$key}}" hidden><br>
                  <input  type="file" class="form-control" wire:model="todo_ordenado.{{$key}}"><br>
                </div>
              </div>
            @elseif($todo_ordenado[$key-1]=="builtin_text")
              <input type="text" class="form-control" wire:model="todo_ordenado.{{$key}}">                
            @endif
          @endif
        @endforeach                         
      @endif
      @if($es_archivo_flow!=false)
        <div class="form-row justify-content-center">
          @if(strlen($resp) > 0 && (($vence==1 && $fecha_caducacion!=null) || ($vence!=1)))
            <button wire:click="update()" class="btn btn-success center">Actualizar</button>
          @else
              <button wire:click="update()" class="btn btn-success center">Actualizar</button>
          @endif
        </div>
      @endif
      @if($es_archivo_flow==false)
        <div class="form-row justify-content-center">
          @if(strlen($resp) > 0 && (($vence==1 && $fecha_caducacion!=null) || ($vence!=1)))
            <button wire:click="update()" class="btn btn-success center">Actualizar</button>
          @else
            <button wire:click="update()" class="btn btn-success center" disabled>Actualizar</button>
          @endif
        </div>
      @endif
    </form>
  </div>
</div>
