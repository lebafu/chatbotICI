<div>
      <div>
          <div>
            <label for="nombre"><b>Nombre:</b></label>
            <input type="text" id="nombre" name="nombre" placeholder="Ingrese su nombre">
          </div>
          <div>
            <label for="email"><b>Correo institucional:</b></label>
            <input type="email" id="email" name="email" placeholder="Ingrese su correo institucional">
          </div>
          <div>
            <label for="comentarios_y_sugerencias"><b>Correo institucional:</b></label>
            <input type="text" id="comentarios_y_sugerencias" name="comentarios_y_sugerencias" placeholder="Ingrese su correo institucional">
          </div>
      </div>   
      <button wire:click="store()" class="btn btn-primary center">
          Enviar
      </button>
</div>

<div class="w-full">
    <div class="flex flex-wrap justify-between items-center mb-16">
      <div 
        <div class="w-auto pr-3">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="nombre">Nombre</label>
            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border {{ $errors->has('nombre') ? ' border-red-500' : 'border-gray-200' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="nombre" wire:model="nombre" type="text" placeholder="Nombre completo...">
            @error('nombre')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
            @enderror
        </div>
         strlen($nombre) poner los {}
        <div class="w-auto px-3">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">Email</label>
            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border {{ $errors->has('name') ? ' border-red-500' : 'border-gray-200' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="email" wire:model="email" type="text" placeholder="Correo electrónico...">
            @error('email')
                <span class="text-red-500 text-xs italic py-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="w-auto pr-3">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="comentarios_y_sugerencias">Nombre</label>
            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border {{ $errors->has('name') ? ' border-red-500' : 'border-gray-200' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="comentarios_y_sugerencias" wire:model="comentarios_y_sugerencias" type="text" placeholder="Nombre completo...">
            @error('comentarios_y_sugerencias')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
            @enderror
        </div>
        <div class="w-auto pl-3 text-right">
            <div class="pt-5">
                <button wire:click="store()" class="px-3 py-2 bg-purple-200 text-purple-500 hover:bg-purple-500 hover:text-purple-100 rounded">Agregar contacto</button>
            </div>
        </div>
    </div>
</div>



<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="nombre">Nombre</label>
            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border {{ $errors->has('nombre') ? ' border-red-500' : 'border-gray-200' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="nombre" wire:model="nombre" type="text" placeholder="Nombre completo...">
            @error('nombre')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
            @enderror
            
        </div>
        <div class="col-md-6">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">Email</label>
            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border {{ $errors->has('name') ? ' border-red-500' : 'border-gray-200' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="email" wire:model="email" type="text" placeholder="Correo electrónico...">
            @error('email')
                <span class="text-red-500 text-xs italic py-1">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="comentarios_y_sugerencias">Nombre</label>
            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border {{ $errors->has('name') ? ' border-red-500' : 'border-gray-200' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="comentarios_y_sugerencias" wire:model="comentarios_y_sugerencias" type="text" placeholder="Nombre completo...">
            @error('comentarios_y_sugerencias')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
            @enderror
            { strlen($comentarios_y_sugerencias) } / 250
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
                <button wire:click="store()" class="px-3 py-2 bg-purple-200 text-purple-500 hover:bg-purple-500 hover:text-purple-100 rounded">Agregar contacto</button>
            
        </div>
    </div>
</div>

2595 ...312