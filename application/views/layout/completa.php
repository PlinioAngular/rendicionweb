<!doctype html>
<html lang = "en">
   <head>
      <meta charset = "utf-8">
      <title>jQuery UI Autocomplete functionality</title>
      <link href = "<?php echo base_url()?>assets/css/jquery-ui.css"
         rel = "stylesheet">
      <script src="<?php echo base_url()?>assets/js/jquery-ui-git.js"></script>

      
      <!-- Javascript -->
      <script>
      
         $(function() {
            var disProyecto  = Array();
            
            <?php foreach($proyectos as $proyecto){  ?>
               disProyecto.push(
                  { label: "<?php echo $proyecto->nombre_proyecto; ?>", value: "<?php echo $proyecto->id_proyecto; ?>",desc:"<?php echo $proyecto->nombre_proyecto; ?>" }
                  
               );
            <?php } ?>
   
            
            
            $( "#automplete-1" ).autocomplete({
               minLength: 0,
               source: disProyecto,
               focus: function( event, ui ) {
                  $( "#automplete-1" ).val( ui.item.label );
                     return false;
               },
               select: function( event, ui ) {
                  $( "#automplete-1" ).val( ui.item.label );
                  var id_proyecto=ui.item.value ;
                  var nombre_proyecto=ui.item.label ;
                  agregar(id_proyecto,nombre_proyecto);
                  return false;
               }
            })				
            .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
               return $( "<li>" )
               .append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
               .appendTo( ul );
            };
         });

      </script>
   </head>
   
   <body>
  
      <!-- HTML --> 
      <div class = "ui-widget">
         <p>Type "a" or "s"</p>
         <label for = "automplete-1">Tags: </label>
         <input id = "automplete-1" onkeyup = "if(event.keyCode == 13) cambio()">
      </div>
      <select class="form-control form-control-sm select2" name="id_proyecto" id="id_proyecto">
									<option value="0">--Seleccione proyecto-</option>
									<?php foreach ($proyectos as $proyecto) { ?>							
									<option value="<?php echo $proyecto->id_proyecto;?>"><?php echo $proyecto->nombre_proyecto;?></option>
									<?php } ?>
								</select>
      <div class="row" id="detalle_egreso">
						<div class="col-sm-12">
							<table id="dataTable12" style="display: block;overflow-x: auto;" class="dataTable table table-bordered table table-hover table-reponsive" width="100px">
								<thead>
									<tr>               
										<th>Fecha</th>
										<th>Periodo</th>
										<th>Proyecto</th>
										<th>Lugar</th>
										<th>Monto</th>
										<th>Detalle</th>   
										<th>Clasificación</th> 
										<th></th>            
									</tr>
								</thead>
								<tbody>
								
									
									</tbody>	
							</table>
						</div>							
					</div>	
      
   </body>
</html>
<script>
    $(document).ready(function() {
      $('#id_proyecto').on('change', function() {
	var proyecto=document.getElementById("id_proyecto");
	
  
    var selectedOption = this.options[proyecto.selectedIndex];
    var nombre_proyecto=selectedOption.text;
	var id_proyecto=selectedOption.value;
    var tbody = $('#dataTable12 tbody'); 
   var fila_contenido ;
   //Agregar fila nueva. 
   
      var fila_nueva = $('<tr id="filadatos" class="filadatos table">'+
	  '<td> <input name="fechas[]" type="date"></td>'+
	  '<td> <input name="periodos[]" value="" placeholder="Periodo"></td>'+
	  '<td> <select name="proyectos[]"><option value="'+id_proyecto+'">'+nombre_proyecto+'</option>'+
      <?php foreach ($proyectos as $proyecto) { ?>							
									'<option value="<?php echo $proyecto->id_proyecto;?>"><?php echo $proyecto->nombre_proyecto;?></option>'+
									<?php } ?>'</select></td>'+
	  '<td> <input name="lugares[]" value="" placeholder="Lugar"></td>'+
	  '<td> <input autocomplete="off" name="montos[]" type="text" id="monto"><p hidden="hidden"></p></td>'+
	  '<td> <input autocomplete="off" name="detalles[]" value="" placeholder="Detalle"></td>'+
	  '<td> <select name="clasificaciones[]"><option>Seleccione una clasificación</option>'+
'<option value=""></option>/select></td>'+
	  
	  '<td> <a href="#" id="borrar" class="btn btn-danger btn-circle"><i class="fas fa-trash"></i> </a></td>'+
	  '</tr>');
      fila_nueva.append(fila_contenido); 
      tbody.append(fila_nueva); 

});
        
    });
    function cambio(){
        $("#id_proyecto").val($("#automplete-1").val());
    }
    function agregar(id,nombre){
      var tbody = $('#dataTable12 tbody'); 
   var fila_contenido ;
   //Agregar fila nueva. 
   
      var fila_nueva = $('<tr id="filadatos" class="filadatos table">'+
	  '<td> <input name="fechas[]" type="date"></td>'+
	  '<td> <input name="periodos[]" value="" placeholder="Periodo"></td>'+
	  '<td> <select name="proyectos[]"><option value="'+id+'">'+nombre+'</option>'+
      <?php foreach ($proyectos as $proyecto) { ?>							
									'<option value="<?php echo $proyecto->id_proyecto;?>"><?php echo $proyecto->nombre_proyecto;?></option>'+
									<?php } ?>'</select></td>'+
	  '<td> <input name="lugares[]" value="" placeholder="Lugar"></td>'+
	  '<td> <input autocomplete="off" name="montos[]" type="text" id="monto"><p hidden="hidden"></p></td>'+
	  '<td> <input autocomplete="off" name="detalles[]" value="" placeholder="Detalle"></td>'+
	  '<td> <select name="clasificaciones[]"><option>Seleccione una clasificación</option>'+
'<option value=""></option>/select></td>'+
	  
	  '<td> <a href="#" id="borrar" class="btn btn-danger btn-circle"><i class="fas fa-trash"></i> </a></td>'+
	  '</tr>');
      fila_nueva.append(fila_contenido); 
      tbody.append(fila_nueva); 
    }
</script>