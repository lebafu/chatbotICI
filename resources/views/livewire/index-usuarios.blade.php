<div class="container-fluid">
	<br><div class="row justify-content-center">
		<div class="col-md-11">
			<div class="card">
				<div class="card-body">
					<div class="row justify-content-center">
						<div class="col-md-11">
							<div>
							    @if (session()->has('message'))
							      <div class="alert alert-success">
							        {{ session('message') }}
							      </div>
							    @endif
							    </div>
							 @if(Auth::user()->name=="Administrador")
							<div id="accordion" role="tablist" aria-multiselectable="true" class="o-accordion">
							  <div class="card multi">
							    <div class="card-header border-bottom border-secondary" style="background-color:#E5E8E8" role="tab" id="heading1">
							      <h5 class="mb-0">
							        <div class="row justify-content-center">
				                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="false" aria-controls="collapse1">
				                <strong> Registrar nuevo usuario al sistema </strong>
				                </a>
							        </div>
							      </h5>
    							</div>
    							<div id="collapse1" class="collapse show" role="tabpanel" aria-labelledby="heading1">
      							<div class="card-block">
      								
         									@include('livewire.crear-usuario')
         							
							      </div>
							    </div>
							  </div>
							</div>
							@else
							<div id="accordion" role="tablist" aria-multiselectable="true" class="o-accordion">
							  <div class="card multi">
							    <div class="card-header border-bottom border-secondary" style="background-color:#E5E8E8" role="tab" id="heading1">
							      <h5 class="mb-0">
							        <div class="row justify-content-center">
				                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="false" aria-controls="collapse1">
				                <strong>Usted no puede añadir usuarios, solo el Administrador</strong>
				                </a>
							        </div>
							      </h5>
    							</div>
							  </div>
							</div>
							@endif
						</div>
					</div>
					<div class="row justify-content-center mt-sm-2 mb-sm-1">	
						<h2 class="text-xl text-center">
			 @if(Auth::user()->name=="Administrador")
              Usuarios del sistema
            </h2>
            @endif
					</div>
					@if(Auth::user()->name=="Administrador")
					<div class="row justify-content-center">
						<div class="col-md-11">
							<table class="table table-hover table-sm">
						    <thead class="thead">
						      <tr style="color: #000; background: #ccc;">
						        <th>Nombre</th>
						        <th>Correo</th>
						        <th>Usuario desde</th>
						        <th></th>
						      </tr>
						    </thead>
						    <tbody>
							    @foreach ($users as $user)
							      <tr>
							        <td>{{$user->name }}</td>
							        <td>{{$user->email }}</td>
							        <td>{{date('d/m/Y', strtotime($user->created_at))}}</td>
							        <td>
						        		<button class="btn btn-danger btn-sm" 
						        		@if($user->id == @Auth::user()->id) disabled @endif
						        		wire:click="delete({{ $user->id}})"><i class="material-icons" style="font-size: 15px">remove_circle_outline</i></button></td>
							      </tr>
							    @endforeach
						    </tbody>
						  </table>	
						</div>
					</div>
					@endif
					@if(Auth::user()->name=="Administrador")
					{{ $users->links() }}
					@endif
				</div>
			</div>
		</div>
	</div>  
</div>