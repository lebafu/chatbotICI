<div>
  <div class="panel-body">


    <form id="uploads" enctype="multipart/form-data" wire:submit.prevent="update">
    
              @if($es_archivo_flow==false)

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
            <div class="form-group col-md-10">
              <div class="col-md-12">
                    <label for="id"><b>Id:</b></label>
                    <input id="id" type="number" class="form-control" name="id" wire:model="selected_id" required autocomplete="nombre" autofocus readonly></input>
                </div>

                  <label for="preguntas"><b>Preguntas que desee agregar (requerido):</b></label>
                  <input wire:model="pregunta.0" type="text" class="form-control" name="preguntas" disabled></input>
            </div>
            <div class="form-group col-md-1">
                  <button class="btn text-white btn-info btn-sm" wire:click="add({{$i}})">Añadir</button>
            </div>
          </div>
          @foreach($inputs as $key => $value)
            <div class="row row-bottom-margin">
              <div class="form-group col-md-10">
                  <input wire:model="pregunta.{{ $value }}" type="text" class="form-control" name="preguntas"></input>
              </div>
              <div class="form-group col-md-1">
                  <button class="btn btn-danger btn-sm" wire:click="remove({{$key}})">X</button>
              </div>
            </div>
          <input wire:model="pregunta_copy.{{ $value }}" type="hidden" class="form-control" name="pregunta_copy"></input>
          @endforeach
          @error('pregunta.*')
              <p class="text-danger">{{ $message }}</p>
          @enderror
    </div>
  @if($pos==0)
    <div class="form-group col-md-5">
      <div class="row">
        <div class="form-group col-md-12">
          <label for="Respuesta"><b>Respuesta (requerido):</b></label>
          <textarea wire:model="resp" type="text" rows="4" class="form-control" placeholder="Respuesta:"></textarea>
        </div>
      </div>
    </div>
@elseif($pos==1)
    <div class="form-group col-md-5">
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
            <input wire:model="fecha_caducacion" type="date" class="form-control"> 
          @else
            <input wire:model="fecha_caducacion" type="date" class="form-control" disabled=""> 
          @endif
        </div>
      </div>       
    </div> 
     @else


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
            <div class="form-group col-md-10">
                <label for="id"></label><b>Id:</b>
                <input id="id" type="number" class="form-control" name="id" wire:model="selected_id" required autocomplete="nombre" autofocus readonly>
          <label for="contexto"><b>Contexto:</b></label>              
            <select wire:model="contexto" name="contexto">
              <option value="global">Global: para todos los usuarios</option>
              <option value="regular">Regular: Solo alumnos en estado regular</option>
              <option value="egresado">Egresado: Solo alumnos egresados</option>
            </select>
                <label for="preguntas"><b>Preguntas que desee agregar (requerido):</b></label>
                  <input wire:model="pregunta.0" type="text" class="form-control" name="preguntas" disabled></input>
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
          <input wire:model="pregunta_copy.{{ $value }}" type="hidden" class="form-control" name="pregunta_copy"></input>
          @endforeach
          @error('pregunta.*')
              <p class="text-danger">{{ $message }}</p>
          @enderror
    </div>
          
                           <b>Nota: El término \n representa el salto de línea en el chatbot, si lo cree necesario en la oración no lo elimine.</b>
                            @for($i=0;$i<$tam_array_builtins_texts_unique;$i++)
                            <input  type="hidden" class="form-control" wire:model="builtins_texts_index_unique.{{$i}}" required>
                            @endfor
                            
                            @foreach($todo_ordenado as $key => $value)
                            @if($key>=2)
                            @if($todo_ordenado[$key-1]=="builtin_image")
                            <label for="img" class="negrita">La imagen seleccionada fue:Malla {{$nombres_imagenes[$key]}}</label>
                            <input   type="hidden" class="form-control" wire:model="nombres_imagenes.{{ $key }}" required>
                            <img src="images/bp/{{$todo_ordenado[$key]}}"><br>
                            <input type="text" wire:model="todo_ordenado_copy.{{$key}}" hidden>
                            <label for="img" class="negrita">Cambiar la imagen:</label>
                            <input  type="file" class="form-control" wire:model="todo_ordenado.{{$key}}">
                            @elseif($todo_ordenado[$key-1]=="builtin_text")
                                <input type="text" class="form-control" wire:model="todo_ordenado.{{$key}}">
                               
                            @endif
                            @endif
                            @endforeach

                         
                        
      </div>
          </div>
      </div>   
    @endif
     @if($es_archivo_flow!=false)
      <div class="form-row justify-content-center">
         @if(strlen($resp) > 0 && (($vence==1 && $fecha_caducacion!=null) || ($vence!=1)))
              <button wire:click="update()" class="btn btn-success center">Actualizar</button>
          @else
              <button wire:click="update()" class="btn btn-success center" disabled>Actualizar</button>
          @endif
    @endif
    @if($es_archivo_flow==false)
      <div class="form-row justify-content-center">
         @if(strlen($resp) > 0 && (($vence==1 && $fecha_caducacion!=null) || ($vence!=1)))
              <button wire:click="update()" class="btn btn-success center">Actualizar</button>
          @else
              <button wire:click="update()" class="btn btn-success center" disabled>Actualizar</button>
          @endif
    @endif
    </div>
</form>
   
</div>
</div>