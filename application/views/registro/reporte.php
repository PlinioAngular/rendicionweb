
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Genere su reporte </h1>
    <p class="mb-4">Puede generar su reporte en Formato Excel o PDF.<a target="_blank" href="https://datatables.net"></a>.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Listado de los detalles de rendición</h6>
            </div>
            <div class="row">
              <div class="col col-sm-10"></div>                
                </div>
            <form id="add_rendicion" name="add_rendicion" accept-charset="utf-8" enctype="multipart/form-data" method="post">  
            <div class="row">
           
            </div>
            <div class="card-body">              
                <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                    </tr>
                  </thead>
                  <tfoot>
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
                    </tr>
                  </tfoot>
                  <tbody>
                                 
                  </tbody>
                </table>
              </div>
          </div>
          </form>
    </div>
</div>
<script>
$(document).ready(function () {
  var condicion="<?php echo $condicion; ?>";
  var egreso="<?php echo $egreso->iddetalle_Costos; ?>";
 $('#dataTable').DataTable({
         "ajax":{
           "data":{condicion:condicion},
           "type":"post",
           "url":"<?php echo base_url('deposito/ajaxReporte'); ?> "
           },
         "language": {
             "lengthMenu": "Mostrar _MENU_ registros por pagina",
             "zeroRecords": "No se encontraron resultados en su busqueda",
             "searchPlaceholder": "Buscar registros",
             "info": "Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros",
             "infoEmpty": "No existen registros",
             "infoFiltered": "(filtrado de un total de _MAX_ registros)",
             "search": "Buscar:",
             "paginate": {
                 "first": "Primero",
                 "last": "Último",
                 "next": "Siguiente",
                 "previous": "Anterior"
             },
         },
         dom: 'Bfrtip',
         buttons: [  {
            extend: 'excelHtml5',
            title: 'Detalles de rendicion del egreso: '+egreso,
            autoFilter: true,
            customize: function(xlsx) {
                var sheet = xlsx.xl.worksheets['sheet1.xml'];
 
                // Loop over the cells in column `C`
                $('[r^="A1"]', sheet).each( function () {
                    // Get the value
                        $(this).attr( 's', '22' );
                    
                });
                $('[r^="B2"]', sheet).each( function () {
                    // Get the value
                        $(this).attr( 's', '5' );
                    
                });
                $('[r^="C2"]', sheet).each( function () {
                    // Get the value
                        $(this).attr( 's', '5' );
                    
                });
                $('[r^="D2"]', sheet).each( function () {
                    // Get the value
                        $(this).attr( 's', '5' );
                    
                });
                $('[r^="E2"]', sheet).each( function () {
                    // Get the value
                        $(this).attr( 's', '5' );
                    
                });
                $('[r^="F2"]', sheet).each( function () {
                    // Get the value
                        $(this).attr( 's', '5' );
                    
                });
                $('[r^="G2"]', sheet).each( function () {
                    // Get the value
                        $(this).attr( 's', '5' );
                    
                });
                $('[r^="H2"]', sheet).each( function () {
                    // Get the value
                        $(this).attr( 's', '5' );
                    
                });
                $('[r^="I2"]', sheet).each( function () {
                    // Get the value
                        $(this).attr( 's', '5' );
                    
                });
                $('[r^="A2"]', sheet).each( function () {
                    // Get the value
                        $(this).attr( 's', '5' );
                    
                });
            }
        },  {
                extend: 'pdfHtml5',
                download: 'open',
                title:'Detalles de Rendición del egreso: '+egreso
            }
         ]
     });
     
 });
 </script>