<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>
<script>
   var ExcelToJSON = function() {
        
      $('#dataTable12').dataTable().fnClearTable();
    $('#dataTable12').dataTable().fnDestroy();
        var hoja=$("#hoja").val();
        var total;
      this.parseExcel = function(file) {
        var reader = new FileReader();

        reader.onload = function(e) {
          var data = e.target.result;
          var workbook = XLSX.read(data, {
            type: 'binary'
          });
            // Here is your object
            var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[hoja]);
            var json_object = JSON.stringify(XL_row_object);
            total=JSON.parse(json_object);
            console.log(total.length);
			if(total.length==0){
				swal(
				'Error',
				'La hoja seleccionada no tiene el formato correcto',
				'error'
				);
			}else{
				swal(
				'Success',
				'Se están subiendo '+total.length+' registros.',
				'success'
				);
				for(var i=0;i<total.length;i++){
                agregar2(total[i].Fecha,total[i].RUC,total[i].Comprobante,total[i].Serie,
                total[i].Numero,total[i].Descripcion,total[i].Cant,total[i].Precio,total[i].Total);
            }
			}
           
         sumar();
        };

        reader.onerror = function(ex) {
          console.log(ex);
        };

        reader.readAsBinaryString(file);
      };
      
      
      
  };

  function handleFileSelect(evt) {
    
    var files = evt.target.files; // FileList object
    var xl2json = new ExcelToJSON();
    xl2json.parseExcel(files[0]);
  } 
</script>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="content-box">
	<div class="row">
		<div class="col-lg-12">
			<div class="element-wrapper">
				
				<div class="element-box">
				<form  id="add_rendicion" name="add_rendicion" accept-charset="utf-8" enctype="multipart/form-data" method="post">
					<div class="row">
						<div class="col-sm-10">
							<h5 class="form-header"> Añadir Registro </h5>
							<div class="form-desc"> Ingrese los datos de rendición </div>
						</div>
						<div class="col-sm-2">
							<a href="<?php echo base_url('FormatoRendicion.xlsx'); ?>"class="btn btn-success"><i class="fas fa-download fa-sm text-white-50"></i> FormatoExcel</a>
						</div>					
					</div>
					<hr>
					<div class="row">						
						<div class="col-sm-6">
							<div class="form-group"><input type="hidden" value="<?php echo $this->session->userdata('id'); ?>" name="id_responsable">
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
						<div class="col-sm-2">
							<div class="form-group">
								<label for="">Gasto Total</label><input type="hidden" value="" name="moneda">
								<input type="text" readonly="" class="form-control form-control-sm" name="total" id="total" value="" placeholder="Total">
							</div>
						</div>	
						<div class="col-sm-2">
							<div class="form-group">
								<label for="">Saldo</label>
								<input type="text" readonly="" class="form-control form-control-sm" name="saldo" id="saldo" value="" placeholder="Saldo">
							</div>
						</div>		
					

					</div>
					<div class="row">
						<div class="col-sm-2">
							<div class="form-group">
								<input class="form-control form-control-sm" autocomplete="off" id="hoja" name="hoja" type="text" placeholder="Hoja a importar">
							</div>
						</div>	
						<div class="col-sm-4">
							<div class="form-group">							
								<div class="input-group">
  								<div class="input-group-prepend">
   								 <span class="input-group-text" id="inputGroupFileAddon01">IMPORTAR</span>
  									</div>
  								<div class="custom-file">
    							<input id="upload" disabled type="file"  name="files[]" class="custom-file-input" 
     								 aria-describedby="inputGroupFileAddon01" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" >
    							<label class="custom-file-label" for="inputGroupFile01">Escoja documento</label>
  								</div>
								</div>
							</div>
						</div>						
						<div class="col-sm-2">						
											
						</div>
						<div class="col-sm-2">
							<div class="form-group">
                            	<button id="btn-agregar" type="button" class="btn btn-secondary btn-flat btn-block"><span class="fa fa-plus"></span> Agregar Item</button></div>
							</div>	
						<div class="col-sm-2">
							<div class="form-group">
                            	<button class="btn btn-primary" type="submit" id="grabar"><span class="fas fa-save"> Guardar Rendicion</button>
							</div>
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
										<th>Electronico</th>										
										<th></th>            
									</tr>
								</thead>
								<tbody>
								</tbody>	
							</table>
						</div>							
					</div>													
					<div class="form-buttons-w">
						
						
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
	agregar3();

		$("form[name='add_rendicion']").submit(function(e) {
			var formData = new FormData($(this)[0]);
			$.ajax({
				
				url: "<?php echo base_url('deposito/rendicion_add'); ?>",
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
						window.location.href="<?php echo base_url('deposito/reporte' ); ?>/"+id;
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
	var random=(Math.random()*100000).toFixed(0);
    var tbody = $('#dataTable12 tbody'); 
   var fila_contenido ;
   //Agregar fila nueva. 
   
      var fila_nueva = $('<tr id="filadatos" class="filadatos table">'+
	  '<td> <input required class="form-control form-control-sm" style="width:150px;" name="fechas[]" type="date" value="<?php echo date("Y-m-d"); ?>"></td>'+
	  '<td> <input required class="form-control form-control-sm numero" style="width:110px;" name="ruc[]" value="0" placeholder="RUC"></td>'+
	  '<td> <select required class="combo comprobante" style="width:120px;" name="comprobantes[]"><option>Seleccione un comprobante</option>'+
	'<?php foreach($comprobantes as $comprobante){ ?><option value="<?php echo $comprobante->nombre; ?>"><?php echo $comprobante->nombre; ?></option><?php } ?></select></td>'+
	  '<td> <input required class="form-control form-control-sm alfa" style="width:80px;" name="serie[]" value="0" placeholder="Serie"></td>'+
	  '<td> <input required class="form-control form-control-sm numero" style="width:90px;" name="numero[]" value="0" placeholder="Número"></td>'+
	 '<td> <input required class="form-control form-control-sm" style="width:260px;" autocomplete="off" name="detalles[]" value="" placeholder="Detalle"></td>'+
	  '<td> <input required class="form-control form-control-sm decimal" style="width:50px;" id="cantidad" name="cantidad[]" value="1" placeholder="Cantidad"><p hidden="hidden">1</p></td>'+
	  '<td> <input required class="form-control form-control-sm decimal" style="width:70px;" id="precio" name="precio[]" value="'+$("#egreso").val()+'" placeholder="Precio"><p hidden="hidden">'+$("#egreso").val()+'</p></td>'+
	  '<td> <p>'+$("#egreso").val()+'</p></td>'+  
	  '<td><div  class="file-input-wrapper" id="'+random+'" style="width: 50px;height: 30px; overflow: hidden;position: relative;visibility:hidden;">'+
	  '<button class="btn btn-secondary" style="display: inline-block;width: 50px;height: 30px;">C.E.</button>'+
	  '<input type="file" id="pdfce" accept="application/pdf" name="userfile'+random+'" style="font-size: 50px;position: absolute;top: 0;right: 0;opacity: 0;" /><input type="hidden" id="random" name="random[]" value="'+random+'"></div></td>'+	  
	  '<td> <a href="#" id="borrar" class="btn btn-danger btn-sm btn-circle"><i class="fas fa-trash"></i> </a></td>'+
	  '</tr>');
      fila_nueva.append(fila_contenido); 
      tbody.append(fila_nueva); 

	  $('.decimal').inputmask('Regex', {regex: "^[0-9]{1,15}(\\.\\d{1,2})?$"});
	  $('.numero').inputmask('Regex', {regex: "^[0-9]{11}?$"});
	  $('.alfa').inputmask('Regex', {regex: "^[0-9-a-z-A-Z]{11}?$"});
	  $('.combo').select2();
	  sumar();
});

$(document).on("click","#borrar", function(){
        $(this).closest("tr").remove();
        sumar();
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
    $(document).on('keyup', '#hoja', function (event) {
		if($(this).val()==""){
			document.getElementById("upload").disabled=true;
		}else{
			document.getElementById("upload").disabled=false;
		}
    });
});

$(function () {
    $(document).on('change', '#pdfce', function (event) {
		$(this).closest("tr").css( "background", "rgba(150, 212, 219, 0.56)" );
    });
});
$(function () {
    $(document).on('change', '.comprobante', function (event) {
		if($(this).val()=="FACTURA ELECTRONICA"){
			$(this).closest("tr").find("td:eq(9)").children("div").css( "visibility", "visible" );
		}else{		
			$(this).closest("tr").find("td:eq(9)").find("input:file").val("");	
			$(this).closest("tr").css( "background", " rgba(245, 246, 244, 0.5)" );
			$(this).closest("tr").find("td:eq(9)").children("div").css( "visibility", "hidden" );
			
		}
		
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
		if($(idf).val()=="FACTURA ELECTRONICA"){
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
	$("input[name=total]").val(total);
	egreso=$("#egreso").val();
	saldo=(egreso-total).toFixed(2);
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
</script>
<script>
    document.getElementById('upload').addEventListener('change', handleFileSelect, false);
   
        
    function agregar2(fecha,ruc,comprobante,serie,numero,descripcion,cantidad,precio,total) {
		var random=(Math.random()*100000).toFixed(0);
    var tbody = $('#dataTable12 tbody'); 
	

    
   var fila_contenido ;
   //Agregar fila nueva. 
   
      var fila_nueva = $('<tr id="filadatos" class="filadatos table">'+
	  '<td> <input required class="form-control form-control-sm" style="width:150px;" name="fechas[]" type="date" value="'+fecha+'"></td>'+
	  '<td> <input required class="form-control form-control-sm numero" style="width:110px;" name="ruc[]" value="'+ruc+'" placeholder="RUC"></td>'+
	  '<td> <select required class="combo comprobante" style="width:120px;" name="comprobantes[]"><option value="'+comprobante+'">'+comprobante+'</option>'+
	'<?php foreach($comprobantes as $comprobante){ ?><option value="<?php echo $comprobante->nombre; ?>"><?php echo $comprobante->nombre; ?></option><?php } ?></select></td>'+
	  '<td> <input required class="form-control form-control-sm alfa" style="width:80px;" name="serie[]" value="'+serie+'" placeholder="Serie"></td>'+
	  '<td> <input required class="form-control form-control-sm numero" style="width:90px;" name="numero[]" value="'+numero+'" placeholder="Número"></td>'+
	 '<td> <input required autocomplete="off" class="form-control form-control-sm" style="width:260px;" name="detalles[]" value="'+descripcion+'" placeholder="Detalle" ></td>'+
	  '<td> <input required autocomplete="off" id="cantidad" class="form-control form-control-sm decimal" style="width:50px;" name="cantidad[]" value="'+cantidad+'" placeholder="Cantidad"><p hidden="hidden">'+cantidad+'</p></td>'+
	  '<td> <input required autocomplete="off" id="precio" class="form-control form-control-sm decimal" style="width:70px;" name="precio[]" value="'+precio+'" placeholder="Precio"><p hidden="hidden">'+precio+'</p></td>'+
	  '<td> <p>'+total+'</p></td>'+  
	  '<td><div class="file-input-wrapper" id="'+random+'" style="width: 50px;height: 30px; overflow: hidden;position: relative;visibility:hidden;">'+
	  '<button class="btn btn-secondary" style="display: inline-block;width: 50px;height: 30px;">C.E.</button>'+
	  '<input type="file" id="pdfce" accept="application/pdf" name="userfile'+random+'" style="font-size: 50px;position: absolute;top: 0;right: 0;opacity: 0;" /><input type="hidden" style="display:block;" id="random" name="random[]" value="'+random+'"></div></td>'+
	  '<td style="width:20px;"> <a href="#" id="borrar" class="btn btn-danger btn-sm btn-circle"><i class="fas fa-trash"></i> </a></td>'+
	  '</tr>');
      fila_nueva.append(fila_contenido); 
      tbody.append(fila_nueva); 
	  $('.decimal').inputmask('Regex', {regex: "^[0-9]{1,15}(\\.\\d{1,2})?$"});
	  $('.numero').inputmask('Regex', {regex: "^[0-9]{11}?$"});
	  $('.alfa').inputmask('Regex', {regex: "^[0-9-a-z-A-Z]{11}?$"});
	  $(".combo").select2();
}
function agregar3() {
	var random=(Math.random()*100000).toFixed(0);
    var tbody = $('#dataTable12 tbody'); 
   var fila_contenido ;
   //Agregar fila nueva. 
   
      var fila_nueva = $('<tr id="filadatos" class="filadatos table">'+
	  '<td> <input required class="form-control form-control-sm" name="fechas[]" type="date" value="<?php echo date("Y-m-d"); ?>"></td>'+
	  '<td> <input required class="form-control form-control-sm numero" style="width:110px;" name="ruc[]" value="0" placeholder="RUC"></td>'+
	  '<td> <select required class="combo comprobante" style="width:120px;" name="comprobantes[]"><option>Seleccione un comprobante</option>'+
	'<?php foreach($comprobantes as $comprobante){ ?><option value="<?php echo $comprobante->nombre; ?>"><?php echo $comprobante->nombre; ?></option><?php } ?></select></td>'+
	  '<td> <input required class="form-control form-control-sm alfa" style="width:80px;" name="serie[]" value="0" placeholder="Serie"></td>'+
	  '<td> <input required class="form-control form-control-sm numero" style="width:90px;" name="numero[]" value="0" placeholder="Número"></td>'+
	 '<td> <input required class="form-control form-control-sm" style="width:260px;" autocomplete="off" name="detalles[]" value="" placeholder="Detalle"></td>'+
	  '<td> <input required class="form-control form-control-sm decimal" style="width:50;" id="cantidad" name="cantidad[]" value="1" placeholder="Cantidad"><p hidden="hidden">1</p></td>'+
	  '<td> <input required class="form-control form-control-sm decimal" style="width:70px;" id="precio" name="precio[]" value="'+$("#egreso").val()+'" placeholder="Precio"><p hidden="hidden">'+$("#egreso").val()+'</p></td>'+
	  '<td> <p>'+$("#egreso").val()+'</p></td>'+  
	  '<td><div  class="file-input-wrapper" id="'+random+'" style="width: 50px;height: 30px; overflow: hidden;position: relative;visibility:hidden;">'+
	  '<button class="btn btn-secondary" style="display: inline-block;width: 50px;height: 30px;">C.E.</button>'+
	  '<input type="file" id="pdfce" accept="application/pdf" name="userfile'+random+'" style="font-size: 50px;position: absolute;top: 0;right: 0;opacity: 0;" /><input type="hidden" id="random" name="random[]" value="'+random+'"></div></td>'+	  
	  '<td> </td>'+
	  '</tr>');
      fila_nueva.append(fila_contenido); 
      tbody.append(fila_nueva); 

	  $('.decimal').inputmask('Regex', {regex: "^[0-9]{1,15}(\\.\\d{1,2})?$"});
	  $('.numero').inputmask('Regex', {regex: "^[0-9]{11}?$"});
	  $('.alfa').inputmask('Regex', {regex: "^[0-9-a-z-A-Z]{11}?$"});
	  $('.combo').select2();
	  sumar();
}

    </script>