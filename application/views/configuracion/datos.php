<div class="container-fluid">
    <!-- Page Heading -->
    <div class="content-box">
	<div class="row">
		<div class="col-lg-12">
			<div class="element-wrapper">
				
				<div class="element-box">
				<form id="edit_persona" name="edit_persona" accept-charset="utf-8" enctype="multipart/form-data" method="post">
					<h5 class="form-header"> Mis datos </h5>
					<div class="form-desc"> Recomendamos que modifique su contraseña. </div>
                    <hr>
					<div class="row">
						<div class="col-sm-6">
						<div class="form-group">
								<label for="">Apellido y Nombres:</label><input value="<?php echo $datos->datos; ?>" readonly autocomplete="off" class="form-control form-control-sm" placeholder="Apellido Paterno" type="text" name="apellido_paterno" id="apellido_paterno">
							</div>
						</div>
											
					</div>	
					<div class="row">						
						<div class="col-sm-3">
						<div class="form-group">
								<label for="">DNI</label><input value="<?php echo $datos->dni; ?>" readonly autocomplete="off" class="form-control form-control-sm" placeholder="DNI" type="text" name="dni" id="dni">
							</div>
						</div>	
						<div class="col-sm-3">
						<div class="form-group">
								<label for="">Fecha de Nacimiento</label><input value="<?php echo $datos->f_nacimiento; ?>" readonly autocomplete="off" class="form-control form-control-sm" type="date" name="fecha_nacimiento" id="fecha_nacimiento">
							</div>
						</div>						
					</div>		
                    <div class="row">
						<div class="col-sm-6">
						    <div class="form-group">
								<label for="">Contraseña:</label><input autocomplete="off" class="form-control form-control-sm" placeholder="Contraseña" type="password" name="password_ant" id="password_ant">
							</div>
						</div>
                    </div>
                    <div class="row">
						<div class="col-sm-6">
						    <div class="form-group">
								<label for="">Nueva Contraseña</label><input autocomplete="off" class="form-control form-control-sm" placeholder="Nueva contraseña" type="password" name="password" id="password">
							</div>
						</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
						    <div class="form-group">
								<label for="">Repita nueva Contraseña:</label><input autocomplete="off" class="form-control form-control-sm" placeholder="Repita contraseña" type="password" name="password_rep" id="password_rep">
							</div>
						</div>				
					</div>												
					<div class="form-buttons-w">
						<button class="btn btn-primary" type="submit" id="grabar"> Actualizar Datos</button>						
						<input  id="errormsg" name="errormsg" value="" type="hidden" hidden="" readonly="">
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
</div> 
<script type="text/javascript">
$(document).ready(function() {
		$("form[name='edit_persona']").submit(function(e) {
			var formData = new FormData($(this)[0]);
			$.ajax({
				
				url: "<?php echo base_url('configuracion/persona_edit'); ?>",
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
