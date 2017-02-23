@extends('app')

@section('content')
	<!-- Mensajes y aletas -->
	<!-- Este se usa para validar formularios -->
	@if (count($errors) > 0)
		<div class="alert alert-danger fade in">
			<strong>Algo no va bien con el modulo Afiliados!</strong> Hay problemas con con los datos diligenciados.<br><br>
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
				</ul>
		</div>
	@endif	
	<!-- Este se usa para mostrar mensajes -->		
	@if(Session::has('message'))
		<div class="alert alert-info fade in">
			<strong>¡Actualización de Informacion!</strong> El registro se ha actualizado adecuadamente.<br><br>
			<ul>								
				<li>{{ Session::get('message') }}</li>
			</ul>
		</div>                
	@endif
    <!-- Mesnsajes de error -->
   @if(Session::has('error'))
		<div class="alert alert-danger fade in">
			<strong>¡Algo no va bien!</strong> Hay problemas con los datos diligenciados.<br><br>
				<ul>								
					<li>{{ Session::get('error') }}</li>								
				</ul>
		</div>                
	@endif
	
	<div class="row">
		<div class="col-md-4">						
			@if(Session::has('modulo'))
			<div class="col-md-11 col-md-offset-1 cuadro">	
				<ul>					
					<dd class="">
						{!! Form::open(array('id'=>'form_search','url' => 'afiliados/buscar')) !!}
							{!! Form::label('usuario', 'Buscador de '.Session::get('modulo.modulo'), array('class' => 'col-md-12 control-label')) !!}
							{!! Form::text('names', '', array('class' => 'form-control','placeholder'=>'Ingresa: Identificación o Nombres de afiliado')) !!}
							{!! Form::hidden('id', Session::get('modulo.id')) !!}
						{!! Form::close() !!}
					</dd>					
				</ul>
			</div>
			<div class="col-md-11 col-md-offset-1 cuadro">
				<ul>
					<dd class="title">Modulo: {{Session::get('modulo.modulo')}}</dd>
					</br>
					<li style="border-bottom: 1px dotted #78a5b1">{{Session::get('modulo.description')}}</li>
					<li> Opciones disponibles: {{ count(Session::get('opaplus.usuario.permisos')[Session::get('modulo.id_aplicacion')]['modulos'][Session::get('modulo.categoria')][Session::get('modulo.id')]['opciones'])}}</li>
					<dd style="border-bottom: 1px dotted #78a5b1">
						<ul>							
						@foreach (Session::get('opaplus.usuario.permisos')[Session::get('modulo.id_aplicacion')]['modulos'][Session::get('modulo.categoria')][Session::get('modulo.id')]['opciones'] as $llave_opt => $opt)
							@if($opt['lugar'] == Session::get('opaplus.usuario.lugar.lugar'))
								@if($opt['vista'] != 'listar')
									<li  type="square" ><a href="{{url(json_decode(Session::get('opaplus.usuario.permisos')[Session::get('modulo.id_aplicacion')]['modulos'][Session::get('modulo.categoria')][Session::get('modulo.id')]['preferencias'])->controlador)}}/{{($opt['accion'])}}/{{Session::get('modulo.id_aplicacion')}}/{{Session::get('modulo.categoria')}}/{{Session::get('modulo.id')}}" >{{$opt[$llave_opt]}}</a></li>   
								@endif
							@endif							
						@endforeach
						</ul>
					</dd>	
					
					<li> Cantidad de Afiliados:  {{Session::get('modulo.total_afiliados')}} </li>
					<dd style="border-bottom: 1px dotted #78a5b1"></dd>
					<li> Cantidad de Sedes:  {{Session::get('modulo.total_sedes')}}</li>
					<dd style="border-bottom: 1px dotted #78a5b1">
						<ul>							
						@foreach (Session::get('modulo.sedes') as $llave_com => $com)
							<li type="square" >{{$com->seat}} : {{$com->total}} Empresas</li>
							<script type="text/javascript"> oli_sede.datos_pie.push({name:"{{$com->seat}}",y:{{$com->total}}});</script>
						@endforeach
						</ul>
					</dd>	
					
					<dd style="border-bottom: 1px dotted #78a5b1">
						<ul>							
						@foreach (Session::get('modulo.empresas') as $llave_com => $com)
							<li type="square" >{{$com->company}} : {{$com->total}}</li>
							<script type="text/javascript">  oli_afiliado.datos_pie.push({name:"{{$com->company}}",y:{{$com->total}}});</script>
						@endforeach
						</ul>
					</dd>
					<li> Cantidad de Vinculos:  {{Session::get('modulo.total_vinculos')}} </li>
					<dd style="border-bottom: 1px dotted #78a5b1">
						<ul>							
						@foreach (Session::get('modulo.vinculos') as $llave_link => $link)
							<li type="square" >{{$link->link}} : {{$link->total}}</li>
							<script type="text/javascript">  oli_vinculo.datos_pie.push({name:"{{$link->link}}",y:{{$link->total}}});</script>
						@endforeach
						</ul>
					</dd>
									
					 											
				</ul>								
			</div>	 
			@else
			<div class="alert alert-danger">
				<strong>¡Algo no va bien!</strong> Hay problemas con los datos diligenciados.<br><br>
					<ul>								
						<li> Los Datos Para la Construcción Del Index no se Consultarón Adecuadamente, o se esta realizando la consulta por medio del URL </li>								
					</ul>
			</div> 			
			@endif			
		</div>
		<div class="col-md-8">
			<div class="col-md-11 col-md-offset-0 cuadro">
				<div id="container_pie_seat" style="width:100%; height:100%;"></div>	
			</div>
			<div class="col-md-11 col-md-offset-0 cuadro">
				<div id="container_pie_company" style="width:100%; height:100%;"></div>	
			</div>
			<div class="col-md-11 col-md-offset-0 cuadro">
				<div id="container_pie_link" style="width:100%; height:100%;"></div>	
			</div>		
			
		</div>
		
	</div>
		
@endsection

@section('script')
	<script type="text/javascript">  	
  		javascript:seg_user.iniciarPie('#container_pie_company','Distribución de Afiliados por Empresa',oli_afiliado.datos_pie);
		javascript:seg_user.iniciarPie('#container_pie_link','Distribución de Afiliados por Vinculo',oli_vinculo.datos_pie);
		javascript:seg_user.iniciarPie('#container_pie_seat','Distribución de Afiliados por Sede',oli_sede.datos_pie);		
		javascript:oli_afiliado.datos_pie = [];		
		javascript:oli_sede.datos_pie = [];		
		javascript:oli_vinculo.datos_pie = [];
					
	</script>
@endsection
    