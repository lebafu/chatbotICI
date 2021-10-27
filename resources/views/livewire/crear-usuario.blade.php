<div class="form-row">
	<div class="form-group col-md-5 ml-sm-3">
		<label for="name"><b>Nombre (requerido):</b></label>
  		<input wire:model="name" type="text" class="form-control" placeholder="Ingrese nombre">
	</div>
	<div class="form-group col-md-5 ml-sm-3">
	  	<label for="Email"><b>Correo institucional (requerido):</b></label>
	  	<input wire:model="email" type="email" class="form-control" placeholder="Ingrese correo institucional">
	  	@error('email')
	    	<p class="text-danger">{{ $message }}</p>
	  	@enderror
	</div>  
	<div class="form-group col-md-1 ml-sm-3">
		<div class="form-row justify-content-center mt-sm-3">
          	@if(strlen($name) > 0 && strlen($email) > 0)
              	<button wire:click="store()" class="btn btn-success center mt-sm-3">Guardar</button>
          	@else
              	<button wire:click="store()" class="btn btn-success center mt-sm-3" disabled>Guardar</button>
       		@endif
    	</div>
	</div> 
</div>