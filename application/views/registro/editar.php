<script>
	$(function(){
		$('.decimal').inputmask('Regex', {regex: "^[0-9]{1,15}(\\.\\d{1,2})?$"});
		$(".combo").select2();
	});
</script>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="content-box">
	<div class="row">
		<div class="col-lg-12">
			<div class="element-wrapper">
				
				<div class="element-box">
				<form  id="edit_rendicion" name="edit_rendicion" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                <input type="hidden" id="idrendicion" name="idrendicion" value="<?php echo $egreso->idrendicion; ?>">
					<h5 class="form-header"> Editar Registro </h5>
					<div class="form-desc"> Modifique los datos de la rendición </div>
					<hr>
					<div class="row">						
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Responsable</label>
								<input type="text" readonly="" class="form-control form-control-sm" value="<?php echo $this->session->userdata('nombre'); ?>">
							</div>
						</div>
                        <div class="col-sm-6">
							<div class="form-group">
								<label for="">Beneficiario</label>
								<input type="text" readonly="" class="form-control form-control-sm" value="<?php echo $egreso->datos; ?>">
							</div>
						</div>
						
						
					</div>
					<div class="row">
                         <div class="col-sm-12">
							<div class="form-group">
								<label for="">Detalle</label>
								<input type="text" readonly="" class="form-control form-control-sm" value="<?php echo $egreso->detalle; ?>">
							</div>
						</div>
																			
					</div>	
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group">
								<label for="">Egreso</label>
								<input type="hidden" name="iddetalle_Costos" id="iddetalle_Costos" value="<?php echo $egreso->iddetalle_Costos; ?>"><input type="text" readonly="" class="form-control form-control-sm" id="egreso" name="egreso" value="<?php echo $egreso->monto; ?>">
							</div>
						</div>	
						<div class="col-sm-3">
							<div class="form-group">
								<label for="">Gasto Total</label>
								<input type="text" readonly="" class="form-control form-control-sm" value="<?=$egreso->gasto; ?>" name="total" id="total" value="" placeholder="Total">
							</div>
						</div>	
						<div class="col-sm-2">
							<div class="form-group">
								<label for="">Saldo</label>
								<input type="text" readonly="" class="form-control form-control-sm" name="saldo" id="saldo" value="<?=$egreso->monto-$egreso->gasto; ?>" placeholder="Saldo">
							</div>
						</div>	
                        
					</div><hr>
					<div class="row">	
						<div class="col-sm-8"></div>				
						<div class="col-sm-2">
							<div class="form-group">
                            <button id="btn-agregar" type="button" class="btn btn-secondary btn-flat btn-block"><span class="fa fa-plus"></span> Agregar Item</button></div>
						</div>	
						<div class="col-sm-2">
							<div class="form-group">
                            <button class="btn btn-primary" type="submit" id="grabar"><span class="fas fa-save"> Guardar Rendicion</button>
						</div>		
    					
					</div>
							
					
						
					<div class="row" id="detalle_egreso">
						<div class="col-sm-12">
							<table id="dataTable12" style="display: block;overflow-x: auto;" class="dataTable table table-bordered table table-hover table-reponsive" width="100px">
								<thead>
									<tr>               
										<th>Fecha</th>
										<th>RUC</th>
										<th>Comprobante</th>
										<th>Serie</th>
										<th>Número</th>										
										<th>Descripción</th>
										<th>Cantidad</th>
										<th>Precio</th>
										<th>Total</th>
										<th></th>            
									</tr>
								</thead>
								<tbody>
                              
                                    <?php foreach($detalles_rendicion as $detalle_rendicion) { ?>
                                    <tr id="filadatos" class="filadatos table">
                                        <td><input type="hidden" name="iddetalle_rendicion[]" value="<?php echo $detalle_rendicion->iddetalle_rendicion; ?>"><p style="visibility:hidden;display:none;"><?=$detalle_rendicion->iddetalle_rendicion ?></p><input class="form-control form-control-sm" name="fechas[]" type="date" value="<?php echo date('Y-m-d',strtotime($detalle_rendicion->fecha)); ?>"></td>
									 <td><input name="ruc[]" class="form-control form-control-sm" style="width:110px;" value="<?php echo $detalle_rendicion->ruc; ?>" placeholder="RUC"></td>
                                        <td> <select class="combo" style="width:120px;" id="a<?php echo $detalle_rendicion->c_electronico; ?>" onChange="mce('<?php echo $detalle_rendicion->c_electronico; ?>')" name="comprobantes[]">
									            <option value="<?php echo $detalle_rendicion->tipo_comprobante; ?>"><?php echo $detalle_rendicion->tipo_comprobante; ?></option>
									            <?php foreach ($comprobantes as $comprobante) { ?>							
									            <option value="<?php echo $comprobante->nombre;?>"><?php echo $comprobante->nombre;?></option>
									            <?php } ?>
								                </select></td>
                                        <td><input name="serie[]" class="form-control form-control-sm" style="width:80px;" value="<?php echo $detalle_rendicion->serie; ?>" placeholder="Serie"></td>
                                        <td><input name="numero[]" class="form-control form-control-sm" style="width:90px;" value="<?php echo $detalle_rendicion->num_comprobante; ?>" placeholder="Número"></td>
                                        
                                        <td> <input autocomplete="off" class="form-control form-control-sm" style="width:180px;" name="detalles[]" value="<?php echo $detalle_rendicion->descripcion;?>" placeholder="Detalle"></td>
	                                    <td> <input id="cantidad" class="form-control form-control-sm decimal" style="width:50px;" name="cantidad[]" value="<?php echo $detalle_rendicion->cantidad;?>" placeholder="Cantidad"><p hidden="hidden"><?php echo $detalle_rendicion->cantidad;?></p></td>
	                                    <td> <input id="precio" class="form-control form-control-sm decimal" style="width:70px;" name="precio[]" value="<?php echo $detalle_rendicion->precio_unitario;?>" placeholder="Precio"><p hidden="hidden"><?php echo $detalle_rendicion->precio_unitario;?></p></td>
	                                    <td> <p><?php echo $detalle_rendicion->precio_unitario*$detalle_rendicion->cantidad;?></p></td>
                                        <td><div class="file-input-wrapper" id="<?php echo $detalle_rendicion->c_electronico; ?>" style="width: 50px;height: 30px; overflow: hidden;position: relative;visibility:hidden;">
	                                    <button class="btn btn-secondary" style="display: inline-block;width: 50px;height: 30px;">C.E.</button>
	                                    <input type="file" name="userfile<?php echo $detalle_rendicion->c_electronico; ?>" style="font-size: 50px;position: absolute;top: 0;right: 0;opacity: 0;" /><input type="hidden" id="random" name="random[]" value="<?php echo $detalle_rendicion->c_electronico; ?>"></div></td>	  
	                                     <td> <a href="#" id="borrar" class="btn btn-danger btn-circle"><i class="fas fa-trash"></i> </a></td>
                                    </tr>
                                    <?php } ?>	
								</tbody>	
							</table>
						</div>							
					</div>													
					<div class="form-buttons-w">						
						<input  id="id_eliminar" name="id_eliminar" value="" type="hidden" hidden="" readonly="">
						<input  id="errormsg" name="errormsg" value="" type="hidden" hidden="" readonly="">
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
</div> 
</div>
<script type="text/javascript">
$(document).ready(function() {
		$("form[name='edit_rendicion']").submit(function(e) {
			var formData = new FormData($(this)[0]);
			$.ajax({
				
				url: "<?php echo base_url('deposito/rendicion_edit'); ?>",
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
						window.location.href="<?php echo base_url('deposito' ); ?>/";
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

	function agregar(){
		var formData = new FormData($("#edit_rendicion")[0]);
			$.ajax({
				
				url: "<?php echo base_url('deposito/agregar_detalle'); ?>",
				type: "POST",
				data:formData,
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
						add_columna(id);
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
	}
	function add_columna(id){
        var random=(Math.random()*100000).toFixed(0);
		var tbody = $('#dataTable12 tbody'); 
        var fila_contenido ;
   //Agregar fila nueva. 
   
      var fila_nueva = $('<tr id="filadatos" class="filadatos table">'+
	  '<td><input type="hidden" name="iddetalle_rendicion[]" value="'+id+'"><p style="visibility:hidden;display:none;">'+id+'</p> <input name="fechas[]" class="form-control form-control-sm" type="date"></td>'+
	 '<td> <input name="ruc[]" class="form-control form-control-sm" style="width:110px;" value="" placeholder="RUC"></td>'+
	  '<td> <select  class="combo" style="width:120px;" name="comprobantes[]"><option>Seleccione un comprobante</option>'+
	'<?php foreach($comprobantes as $comprobante){ ?><option value="<?php echo $comprobante->nombre; ?>"><?php echo $comprobante->nombre; ?></option><?php } ?></select></td>'+
	  '<td> <input class="form-control form-control-sm" style="width:80px;" name="serie[]" value="" placeholder="Serie"></td>'+
	  '<td> <input class="form-control form-control-sm" style="width:90px;" name="numero[]" value="" placeholder="Número"></td>'+
	  '<td> <input autocomplete="off" class="form-control form-control-sm" style="width:180px;" name="detalles[]" value="" placeholder="Detalle"></td>'+
	  '<td> <input class="form-control form-control-sm decimal" style="width:50;" id="cantidad" class="decimal" name="cantidad[]" value="0" placeholder="Cantidad"><p hidden="hidden"></p></td>'+
	  '<td> <input class="form-control form-control-sm decimal" style="width:70px;" id="precio" class="decimal" name="precio[]" value="0" placeholder="Precio"><p hidden="hidden"></p></td>'+
	  '<td> <p></p></td>'+  
	  '<td><div class="file-input-wrapper" style="width: 50px;height: 30px; overflow: hidden;position: relative;">'+
	  '<button class="btn btn-secondary" style="display: inline-block;width: 50px;height: 30px;">C.E.</button>'+
	  '<input type="file" name="userfile'+random+'" style="font-size: 50px;position: absolute;top: 0;right: 0;opacity: 0;" /><input type="hidden" id="random" name="random[]" value="'+random+'"></div></td>'+	  
	  
	  '<td> <a href="#" id="borrar" class="btn btn-danger btn-circle"><i class="fas fa-trash"></i> </a></td>'+
	  '</tr>');
      fila_nueva.append(fila_contenido); 
      tbody.append(fila_nueva); 
      $('.decimal').inputmask('Regex', {regex: "^[0-9]{1,15}(\\.\\d{1,2})?$"});
	  $('.combo').select2();
	}
	

$('#btn-agregar').on('click', function() {
	swal({
  		title: "¿Está segura(o) de hacer la modificación?",
  		text: "Al aceptar se agregará un registro a la rendición!",
  		icon: "warning",
  		buttons: true,
  		dangerMode: true,
		})
		.then((willDelete) => {
  		if (willDelete) {
    		agregar();
  		} else {
    	swal("El registró no se modificó!");
  		}
});
	

});
function eliminar(id){
	var formData = new FormData($("#edit_rendicion")[0]);
			$.ajax({
				
				url: "<?php echo base_url('deposito/eliminar_detalle'); ?>",
				type: "POST",
				data:formData,
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

						 //will call the function after 2 secs.
					}
					else
					{
						$('#errormsg').val(msg);
						openerror(msg);
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
}
$(document).on("click","#borrar", function(){
	var tr = $(this).closest("tr").find("td:eq(0)").children("p").text();
	$("#id_eliminar").val(tr);
	swal({
  		title: "¿Está segura(o) de hacer la modificación?",
  		text: "Al aceptar se agregará un registro a la rendición!",
  		icon: "warning",
  		buttons: true,
  		dangerMode: true,
		})
		.then((willDelete) => {
  		if (willDelete) {
			$(this).closest("tr").remove();
			eliminar(tr);			
        	sumar();
  		} else {
    	swal("El registró no se modificó!");
  		}
		});
	
    });

$(function () {
    $(document).on('keyup', '#cantidad', function (event) {
		$(this).closest("tr").find("td:eq(6)").children("p").text($(this).val());				
        cantidad = $(this).val();
        precio = $(this).closest("tr").find("td:eq(7)").text();
        importe = cantidad * precio;
        $(this).closest("tr").find("td:eq(8)").children("p").text(importe.toFixed(2));
		sumar();
    });
});
$(function () {
    $(document).on('keyup', '#precio', function (event) {
		$(this).closest("tr").find("td:eq(7)").children("p").text($(this).val());
        precio = $(this).val();
        cantidad = $(this).closest("tr").find("td:eq(6)").text();
        importe = cantidad * precio;
        $(this).closest("tr").find("td:eq(8)").children("p").text(importe.toFixed(2));
		sumar();
    });
});
});

function mce(id){
	var idf="#a"+id;
		if($(idf).val()=="FACTURA"){
			document.getElementById(id).style.visibility = "visible";
		}else{
			document.getElementById(id).style.visibility = "hidden";
		}
    
}

function sumar(){
	var total=0;
	$("#dataTable12 tbody tr").each(function(){
		total=total + Number($(this).find("td:eq(8)").children("p").text());
	});
	$("input[name=total]").val(total.toFixed(2));
	egreso=$("#egreso").val();
	saldo=egreso-total;
	$("input[name=saldo]").val(saldo.toFixed(2));
}
 function opensuccess(){
	swal(
			'Correcto',
			'El registro se completo satisfactoriamente.',
			'success'
		);
 }
 function openerror(msg){
		var errormsg = msg;
		swal(
			'Error',
			'El registro no pudo llevarse a cabo. \n '+errormsg+'',
			'error'
		);
		$('#errormsg').val("");
	}
</script>