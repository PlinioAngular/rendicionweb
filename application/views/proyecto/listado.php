<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Proyectos</h1>
    <p class="mb-4">La presente tabla muestra los proyectos que se ejecutan dentro de <a target="_blank" href="http://sistemas.sattelital.com.pe/">Grupo Satelital</a> con opción a editar y dar de baja.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Listado de Proyectos</h6>
            </div>
            <hr>
            <div class="row">
              <div class="col col-sm-10"></div>
                <div class="col col-sm-2">
                <a class="btn btn-primary" href="<?php echo base_url(); ?>proyecto/registrar">Nuevo Proyecto</a>
                </div>
                </div>
            <div class="card-body">
              
                <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Código</th>
                      <th>Cliente</th>
                      <th>Gerencia</th>
                      <th>Área</th>
                      <th>Sub Área</th>
                      <th>Empresa</th>   
                      <th>Acciones</th>                    
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nombre</th>
                      <th>Código</th>
                      <th>Cliente</th>
                      <th>Gerencia</th>
                      <th>Área</th>
                      <th>Sub Área</th>
                      <th>Empresa</th>   
                      <th>Acciones</th>   
                      
                    </tr>
                  </tfoot>
                  <tbody>
                                
                  </tbody>
                </table>
              </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
 $('#dataTable').DataTable({
         "ajax":{
           "type":"post",
           "url":"<?php echo base_url('proyecto/ajax'); ?> "
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