<div class="container-fluid">
    <!-- Page Heading -->
    <div class="content-box">
	<div class="row">
		<div class="col-lg-12">
			<div class="element-wrapper">
				
				<div class="element-box">
				<form id="add_proyecto" name="add_proyecto" accept-charset="utf-8" enctype="multipart/form-data" method="post">
					<h5 class="form-header"> Añadir Proyecto </h5>
					<div class="form-desc"> Describe todas las características del proyecto. </div>
					<div class="row">
					<div class="col-sm-8">
						<div class="form-group">
								<label for="">Nombre de Proyecto</label><input autocomplete="off" class="form-control form-control-sm" placeholder="Nombre del proyecto" type="text" name="nombre_proyecto" id="nombre_proyecto">
							</div>
						</div>
						<div class="col-sm-4">
						<div class="form-group">
								<label for="">Código</label><input autocomplete="off" class="form-control form-control-sm" placeholder="Código" type="text" name="codigo_proyecto" id="codigo_proyecto">
							</div>
						</div>						
					</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label>Descripción del Proyecto</label><textarea class="form-control form-control-sm" rows="3" placeholder="Describe algunas características del proyecto..." name="descripcion" id="descripcion"></textarea>
							</div>
						</div>
					</div>		
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Cliente</label>
								<a href="#" id="midtipopro" data-toggle="modal" data-target="#modal_general" onclick="modaledit(this.id);"><i class="fa fa-plus-square"></i></a>
								<select class="form-control form-control-sm select2" name="id_cliente" id="id_cliente">
									<?php foreach ($clientes as $cliente) { ?>							
									<option value="<?php echo $cliente->id_cliente;?>"><?php echo $cliente->cliente;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
              				<label for="">Gerencia</label>
								<a href="#" id="midtipopro" data-toggle="modal" data-target="#modal_general" onclick="modaledit(this.id);"><i class="fa fa-plus-square"></i></a>
								<select class="form-control form-control-sm select2" name="id_gerencia" id="id_gerencia">
									<?php foreach ($gerencias as $gerencia) { ?>							
									<option value="<?php echo $gerencia->id_gerencia;?>"><?php echo $gerencia->gerencia;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Área</label>
								<a href="#" id="midtipopro" data-toggle="modal" data-target="#modal_general" onclick="modaledit(this.id);"><i class="fa fa-plus-square"></i></a>
								<select class="form-control form-control-sm select2" name="id_area" id="id_area">
									<?php foreach ($areas as $area) { ?>							
									<option value="<?php echo $area->id_area;?>"><?php echo $area->area;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
              				<label for="">Sub Área</label>
								<a href="#" id="midtipopro" data-toggle="modal" data-target="#modal_general" onclick="modaledit(this.id);"><i class="fa fa-plus-square"></i></a>
								<select class="form-control form-control-sm select2" name="id_sub_area" id="id_sub_area">
									<?php foreach ($sub_areas as $sub_area) { ?>							
									<option value="<?php echo $sub_area->id_sub_area;?>"><?php echo $sub_area->sub_area;?></option>
									<?php } ?>
								</select>
							</div>
						</div>						
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Empresa</label>
								<a href="#" id="midtipopro" data-toggle="modal" data-target="#modal_general" onclick="modaledit(this.id);"><i class="fa fa-plus-square"></i></a>
								<select class="form-control form-control-sm select2" name="id_empresa" id="id_empresa">
									<?php foreach ($empresas as $empresa) { ?>							
									<option value="<?php echo $empresa->id_empresa;?>"><?php echo $empresa->empresa;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
										
					</div>
					
					
					<div class="form-buttons-w">
						<button class="btn btn-primary" type="submit" id="grabar"> Guardar - Grabar</button>
						
						<input  id="errormsg" name="errormsg" value="" type="hidden" hidden="" readonly="">
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>

</div>

<!-- #################################### MODALS	#################################### -->
<div aria-hidden="true" class="onboarding-modal modal fade animated" id="modal_general" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-lg modal-centered" role="document">
		<div class="modal-content text-center">
			<!-- LOADING -->
			<div style="position: relative;">
				<div style="position: absolute;left: 80px;top: 30px;color: red;">
					<img src="<?php echo base_url(); ?>/public/assets/img/loading/Preloader_2.gif" alt=""><br>
				Procesando Información.</div>
			</div>
			
			<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span class="close-label">Salir</span><span class="os-icon os-icon-close"></span></button>
			<div class="onboarding-side-by-side">
				<div class="onboarding-media">
					<img alt="" src="<?php echo base_url(); ?>public/assets/img/bigicon5.png" width="200px">
				</div>
				<div class="onboarding-content with-gradient">
					<h4 class="onboarding-title" name="mftitle" id="mftitle">General</h4>
					<form	id="add_general" name="add_general" accept-charset="utf-8" method="post">
						<input type="hidden" name="mclase" id="mclase" value="" readonly="" hidden="">
						<div class="row">
							<div class="col-sm-12" id="mdivuno">
								<div class="form-group">
									<label for="" id="firsttext">Nombre</label>
									<input autocomplete="off" class="form-control form-control-sm" placeholder="Ingrese Información" type="text" id="mvaluno" name="mvaluno" required="">
								</div>
							</div>
							<div class="col-sm-12" id="mdivdos">
								<div class="form-group">
									<label for="" id="secondtext">Código</label>
									<input autocomplete="off" class="form-control form-control-sm" placeholder="Ingrese Código" type="text" id="mvaldos" name="mvaldos" required="">
								</div>
							</div>	
							<div class="col-sm-12" id="mdivtres">
								<div class="form-group">
									<label for="" id="threetext">Descripción</label>
									<input autocomplete="off" class="form-control form-control-sm" placeholder="Ingrese Descripción" type="text" id="mvaltres" name="mvaltres">
								</div>
							</div>
							<div class="col-sm-12">
								&nbsp;
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<button class="btn btn-primary" type="submit" id="mgrabar" >Grabar o Guardar</button>
									<button class="btn btn-secondary" data-dismiss="modal" type="button" id="mcerrar" > Cerrar</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
		$("form[name='add_proyecto']").submit(function(e) {
			var formData = new FormData($(this)[0]);
			$.ajax({
				
				url: "<?php echo base_url('inicio/proyecto_add'); ?>",
				type: "POST",
				data: formData,
				async: true,
				beforeSend: function(){
					$('#guardarform').attr('disabled', 'disabled');
					$('#grabar').prop('disabled', true);
				},
				success: function (msg) {
				var str=msg.split("_");
				var id=str[1];
				var status=str[0];
				
					if(status=="si")
					{
						opensuccess();

						setTimeout(function () {
						window.location.href="<?php echo base_url('inicio' ); ?>/";
						}, 1500); //will call the function after 2 secs.
					}
					else
					{
						$('#errormsg').val(msg);
						openerror();
						return false;
					}
				},
				error: function(data, xhr,textStatus,errorThrown) {
					if(textStatus=='timeout'){
						$('#errormsg').val("Error: Tiempo de conexión agotado.");
						openerror();
					 } else {
					 	$('#errormsg').val(data);
						openerror();
					 }
					//alert(JSON.stringify(errorThrown));
				},			
				complete: function() {
					$('#grabar').prop('disabled', false);
				},
				timeout: 2000,
				cache: false,
				contentType: false,
				processData: false
			});
			e.preventDefault();
			opensuccess();
		
	});
});
 function opensuccess(){
	swal(
			'Correcto',
			'El registro se completo satisfactoriamente.',
			'success'
		);
 }
 function openerror(){
		var errormsg = $('#errormsg').val();
		swal(
			'Error',
			'El registro no pudo llevarse a cabo. \n '+errormsg+'',
			'error'
		);
		$('#errormsg').val("");
	}
</script>