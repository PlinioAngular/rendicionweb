
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Listado de Egresos </h1>
    <p class="mb-4">La presente tabla muestra los egresos a rendir de un personal con opción de hacer la rendicion de manera individual o en sumatoria|Editar Rendiciones|Generar Reporte Excel.<a target="_blank" href="https://datatables.net"></a>.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Listado de egresos</h6>
            </div>
            <div class="row">
              <div class="col col-sm-10"></div>                
                </div>
            <form action="<?php echo base_url('deposito/suma');?>"  id="add_rendicion" name="add_rendicion" accept-charset="utf-8" enctype="multipart/form-data" method="post">  
            <div class="row">
            <?php if($condicion==0){ ?>
              <div class="col-sm-2">
							  <div class="form-group">
							    <label for="">&nbsp;</label>
                  <button id="btn-agregar" type="submit" class="btn btn-success btn-flat btn-block"><span class="fa fa-plus"></span> Sumar</button>
                </div>
						  </div>
            <?php } ?>
            </div>
            <div class="card-body">              
                <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Suma</th>
                      <th>Fecha</th>
                      <th>Detalle</th>
                      <th>Beneficiario</th>                        
                      <th>Estado</th> 
                      <th>Egreso</th> 
                      <th>Rendido</th> 
                      <th>Saldo</th> 
                      <th>Acciones</th>                   
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Suma</th>
                      <th>Fecha</th>
                      <th>Detalle</th> 
                      <th>Beneficiario</th>                        
                      <th>Estado</th> 
                      <th>Egreso</th> 
                      <th>Rendido</th> 
                      <th>Saldo</th> 
                      <th>Acciones</th>     
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
 $('#dataTable').DataTable({
         "ajax":{
           "data":{condicion:condicion},
           "type":"post",
           "url":"<?php echo base_url('deposito/ajax'); ?> "
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
         }
     });
     
 });
 </script>