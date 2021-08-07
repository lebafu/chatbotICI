<div>
	<form id="form" action="{{route('qna.pregunta_sin_respuesta')}}" method="post">
	    @csrf
	    <div class="form-row">
	        <div class="form-group col-md-6">
	          <label for="Nombre"><b>Nombre:</b></label>
	          <input type="text" class="form-control" id="Nombre" name="nombre" placeholder="Ingrese su nombre">
	        </div>
	        <div class="form-group col-md-6">
	          <label for="Email"><b>Correo institucional:</b></label>
	          <input type="text" class="form-control" id="Email" name="email" placeholder="Ingrese su correo institucional">
	        </div>
	    </div>
	    <div class="form-group">
	        <label for="preguntas"><b>Ingrese sus preguntas separadas por coma:</b></label>
	        <textarea type="text" rows="4" class="form-control" name="preguntas"></textarea>
	      </div>    
	    <button type="submit" class="btn btn-primary center">
	        Enviar
	    </button>
	</form>
</div>
