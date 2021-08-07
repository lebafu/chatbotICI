<div>
  <form id="form2" action="{{route('qna.store_comentarios_y_sugerencias')}}" method="post">
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
          <label for="comentarios"><b>Ingrese sus comentarios o sugerencias:</b></label>
          <textarea type="text" rows="4" class="form-control" name="comentarios"></textarea>
        </div>    
      <button type="submit" class="btn btn-primary center">
          Enviar
      </button>
  </form>
</div>