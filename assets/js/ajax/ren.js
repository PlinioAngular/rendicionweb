
$(document).ready(function() {
		$("form[name='add_rendicion']").submit(function(e) {
			var formData = new FormData($(this)[0]);
			$.ajax({
				
				url: "<?php echo base_url('rendicion/rendicion_add'); ?>",
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
						window.location.href="<?php echo base_url('rendicion' ); ?>/";
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
	

$('#btn-agregar').on('click', function() {
    var tbody = $('#dataTable12 tbody'); 
   var fila_contenido ;
   //Agregar fila nueva. 
   
      var fila_nueva = $('<tr id="filadatos" class="filadatos table">'+
	  '<td> <input name="fechas[]" type="date"></td>'+
	  '<td> <input name="periodos[]" value="" placeholder="Periodo"></td>'+
	  '<td> <input name="ruc[]" value="" placeholder="RUC"></td>'+
	  '<td> <select name="comprobantes[]"><option>Seleccione un comprobante</option>'+
	'<?php foreach($comprobantes as $comprobante){ ?><option value="<?php echo $comprobante->id_comprobante; ?>"><?php echo $comprobante->comprobante; ?></option><?php } ?></select></td>'+
	  '<td> <input name="serie[]" value="" placeholder="Serie"></td>'+
	  '<td> <input name="numero[]" value="" placeholder="Número"></td>'+
	  '<td> <select name="proyectos[]"><option value=""></option>'+
     ' <?php foreach ($proyectos as $proyecto) { ?>		'+					
									'<option value="<?php echo $proyecto->id_proyecto; ?>"><?php echo $proyecto->nombre_proyecto; ?></option>'+
									'<?php } ?></select></td>'+
		'<td> <select name="clasificaciones[]"><option>Seleccione una clasificación</option>'+
		'<?php foreach($clasificaciones as $clasificacion){ ?><option value="<?php echo $clasificacion->id_clasificacion; ?>"><?php echo $clasificacion->clasificacion; ?></option><?php } ?></select></td>'+
		'<td> <select name="tipo_actividad[]"><option>Seleccione una tipo</option>'+
		'<?php foreach($tipos_actividad as $tipo_actividad){ ?><option value="<?php echo $tipo_actividad->id_tipo_actividad; ?>"> <?php echo $tipo_actividad->tipo_actividad; ?></option><?php } ?></select></td>'+
		'<td> <input autocomplete="off" name="detalles[]" value="" placeholder="Detalle"></td>'+
	  '<td> <input id="cantidad" name="cantidad[]" value="0" placeholder="Cantidad"><p hidden="hidden"></p></td>'+
	  '<td> <input id="precio" name="precio[]" value="0" placeholder="Precio"><p hidden="hidden"></p></td>'+
	  '<td> <p></p></td>'+  
	  
	  '<td> <a href="#" id="borrar" class="btn btn-danger btn-circle"><i class="fas fa-trash"></i> </a></td>'+
	  '</tr>');
      fila_nueva.append(fila_contenido); 
      tbody.append(fila_nueva); 

});

$(document).on("click","#borrar", function(){
        $(this).closest("tr").remove();
        sumar();
    });

$(function () {
    $(document).on('keyup', '#cantidad', function (event) {
		$(this).closest("tr").find("td:eq(10)").children("p").text($(this).val());				
        cantidad = $(this).val();
        precio = $(this).closest("tr").find("td:eq(11)").text();
        importe = cantidad * precio;
        $(this).closest("tr").find("td:eq(12)").children("p").text(importe.toFixed(2));
		sumar();
    });
});
$(function () {
    $(document).on('keyup', '#precio', function (event) {
		$(this).closest("tr").find("td:eq(11)").children("p").text($(this).val());
        precio = $(this).val();
        cantidad = $(this).closest("tr").find("td:eq(10)").text();
        importe = cantidad * precio;
        $(this).closest("tr").find("td:eq(12)").children("p").text(importe.toFixed(2));
		sumar();
    });
});
});

function sumar(){
	var total=0;
	$("#dataTable12 tbody tr").each(function(){
		total=total + Number($(this).find("td:eq(12)").children("p").text());
	});
	$("input[name=total]").val(total);
	egreso=$("#egreso").val();
	saldo=egreso-total;
	$("input[name=saldo]").val(saldo);
}
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
    document.getElementById('upload').addEventListener('change', handleFileSelect, false);
   
        
        function agregar2(fecha,ruc,comprobante,serie,numero,descripcion,cantidad,precio,total) {
    var tbody = $('#dataTable12 tbody'); 
    
   var fila_contenido ;
   //Agregar fila nueva. 
   
      var fila_nueva = $('<tr id="filadatos" class="filadatos table">'+
	  '<td> <input name="fechas[]" type="date" value="'+fecha+'"></td>'+
	  '<td> <input name="periodos[]" value="" placeholder="Periodo"></td>'+
	  '<td> <input name="ruc[]" value="'+ruc+'" placeholder="RUC"></td>'+
	  '<td> <select name="comprobantes[]"><option>'+comprobante+'</option>'+
	'<?php foreach($comprobantes as $comprobante){ ?><option value="<?php echo $comprobante->id_comprobante; ?>"><?php echo $comprobante->comprobante; ?></option><?php } ?></select></td>'+
	  '<td> <input name="serie[]" value="'+serie+'" placeholder="Serie"></td>'+
	  '<td> <input name="numero[]" value="'+numero+'" placeholder="Número"></td>'+
	  '<td> <select name="proyectos[]"><option value=""></option>'+
      '<?php foreach ($proyectos as $proyecto) { ?>		'+					
									'<option value="<?php echo $proyecto->id_proyecto; ?>"><?php echo $proyecto->nombre_proyecto; ?></option>'+
									'<?php } ?></select></td>'+
		'<td> <select name="clasificaciones[]"><option>Seleccione una clasificación</option>'+
		'<?php foreach($clasificaciones as $clasificacion){ ?><option value="<?php echo $clasificacion->id_clasificacion; ?>"><?php echo $clasificacion->clasificacion; ?></option><?php } ?></select></td>'+
		'<td> <select name="tipo_actividad[]"><option>Seleccione una tipo</option>'+
		'<?php foreach($tipos_actividad as $tipo_actividad){ ?><option value="<?php echo $tipo_actividad->id_tipo_actividad; ?>"><?php echo $tipo_actividad->tipo_actividad; ?></option><?php } ?></select></td>'+
		'<td> <input autocomplete="off" name="detalles[]" value="'+fecha+'" placeholder="Detalle" ></td>'+
	  '<td> <input id="cantidad" name="cantidad[]" value="'+cantidad+'" placeholder="Cantidad"><p hidden="hidden"></p></td>'+
	  '<td> <input id="precio" name="precio[]" value="'+precio+'" placeholder="Precio"><p hidden="hidden"></p></td>'+
	  '<td> <p>'+total+'</p></td>'+  
	  
	  '<td> <a href="#" id="borrar" class="btn btn-danger btn-circle"><i class="fas fa-trash"></i> </a></td>'+
	  '</tr>');
      fila_nueva.append(fila_contenido); 
      tbody.append(fila_nueva); 
    
}
