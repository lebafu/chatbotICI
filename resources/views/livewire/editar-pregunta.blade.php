<div>
  <div class="panel-body">

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
              @if($es_archivo_flow==false)
                  <label for="preguntas"><b>Preguntas que desee agregar (requerido):</b></label>
                  <input wire:model="pregunta.0" type="text" class="form-control" name="preguntas"></input>
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
@elseif($pos==1)
    <div class="form-group col-md-5">
      <div class="row">
        <div class="form-group col-md-12">
          <label for="Respuesta"><b>Respuesta (requerido):</b></label>
          <textarea wire:model="resp" type="text" rows="4" class="form-control" placeholder="Respuesta:" disabled></textarea>
        </div>
      </div>
       <div>
            <label for="img" class="negrita">La imagen seleccionada fue:</label>
            <input name="imagen" type=text class="form-control" value="{{$name_image}}" readonly="readonly" hidden="hidden">
            <img src="images/bp/{{$name_image}}">
      </div>
                       
        <div>
          <label>Cambiar Imagen: </label>
          <input type="file" id="image_nueva" name="image_nueva" class="form-control"/>
          <div class='text-danger'>{{$errors->first('image_nueva')}}</div>
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
     <div class="form-row justify-content-center">
      <div class="form-group col-md-12">
          <div class="row row-bottom-margin">
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
          
                           <b>Nota: El término \n representa el salto de línea en el chatbot, si lo cree necesario en la oración no lo elimine.</b>
                            @for($i=0;$i<$tam_array_builtins_texts_unique;$i++)
                            <input  id="builtins_texts_index_unique{{$i}}" type="hidden" class="form-control" name="builtins_texts_unique[]" value="{{$builtins_texts_index_unique[$i]}}" required>
                            @endfor

                            @for ($i=2; $i<$tam_array_todo;$i=$i+3)
                             @if($todo_ordenado[$i-1]=="builtin_image")

                            <label for="img" class="negrita">La imagen seleccionada fue:Malla {{$nombres_imagenes[$i]}}</label>
                            <input  id="nombres_imagenes{{$i}}" type="hidden" class="form-control" name="imagenes_news[]" value="{{$nombres_imagenes[$i]}}" required>

                            <img src="images/bp/{{$todo_ordenado[$i]}}">
                            <input id="imagen_actual{{$i}}" name=imagen_actual[] type="text" value="{{$todo_ordenado[$i]}}" hidden>
                            <label for="img" class="negrita">Cambiar la imagen:</label>
                            <input id="imagen_nueva{{$i}}" name="imagen_nueva[]" type="file" class="form-control" value={{$todo_ordenado[$i]}}>
                            @elseif($todo_ordenado[$i-1]=="builtin_text")
                                        <input  id="string{{$i}}" type="text" class="form-control" name="string[]" value="{{$todo_ordenado[$i]}}"  required>
                                      <input  id="textos_originales{{$i}}" type="hidden" class="form-control" name="textos_originales[]" value="{{$todo_ordenado[$i]}}" required>
                                      <input type="hidden" id="builtin_tipo{{$i-1}}" name="builtin_tipo[]" value="{{$todo_ordenado[$i-1]}}">
                                       <input type="hidden" id="builtin_codigo{{$i-2}}" name="builtin_codigo[]" value="{{$todo_ordenado[$i-2]}}">


                                    @endif
                            @endfor
                         
                        @endif
      </div>
          </div>
      </div>       


    <div class="form-row justify-content-center">
          @if(strlen($resp) > 0 && (($vence==1 && $fecha_caducacion!=null) || ($vence!=1)))
              <button wire:click="update()" class="btn btn-success center">Actualizar</button>
          @else
              <button wire:click="update()" class="btn btn-success center" disabled>Actualizar</button>
          @endif
    </div>
</div>