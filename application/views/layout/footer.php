<!-- #################################### MODALS	#################################### -->
<div aria-hidden="true" class="onboarding-modal modal fade animated" id="modal_general" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-lg modal-centered" role="document">
		<div class="modal-content text-center">
			<!-- LOADING -->
			<div style="position: relative;">
				<div style="position: absolute;left: 80px;top: 30px;color: red;">
					<img src="<?php echo base_url(); ?>/assets/gif/loading-4.gif" alt=""><br>
				Procesando Información.</div>
			</div>
			
			<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span class="close-label">Salir</span><span class="os-icon os-icon-close"></span></button>
			<div class="onboarding-side-by-side">
				<div class="onboarding-media">
					<img alt="" src="<?php echo base_url(); ?>assets/img/mantenimiento.jpg" width="200px">
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
 
 <!-- Footer -->
 <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Sistema Proyectos Satelital</span>
          </div>
        </div>
 </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">¿Está seguro de salir?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Si selecciona salir su sesión caducará.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <a class="btn btn-primary" href="<?php echo base_url('auth/logout'); ?>">Salir</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url()?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?php echo base_url()?>assets/js/input-mask/jquery.inputmask.js"></script>
  <script src="<?php echo base_url()?>assets/js/input-mask/jquery.inputmask.regex.extensions.js"></script>
  <script src="<?php echo base_url()?>assets/js/input-mask/jquery.inputmask.extensions.js"></script>
  
  <link href="<?php echo base_url()?>assets/js/selected/css/select2.min.css" rel="stylesheet" />
  <script src="<?php echo base_url()?>assets/js/selected/js/select2.min.js"></script> 

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url()?>assets/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?php echo base_url()?>assets/vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts 
  <script src="<?php echo base_url()?>assets/js/demo/chart-area-demo.js"></script>
  <script src="<?php echo base_url()?>assets/js/demo/chart-pie-demo.js"></script>-->

  <!-- Page level plugins -->
  <script src="<?php echo base_url()?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  
  <script src="<?php echo base_url()?>assets/vendor/datatables/dataTables.buttons.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendor/datatables/buttons.flash.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendor/datatables/jszip.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendor/datatables/pdfmake.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendor/datatables/vfs_fonts.js"></script>
  <script src="<?php echo base_url()?>assets/vendor/datatables/buttons.html5.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendor/datatables/dataTables.rowGroup.min.js"></script>
  
  <!-- Page level custom scripts -->
  <script src="<?php echo base_url()?>assets/js/demo/datatables-demo.js"></script>

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <link href = "<?php echo base_url()?>assets/css/jquery-ui.css"
         rel = "stylesheet">
      <script src="<?php echo base_url()?>assets/js/jquery-ui-git.js"></script>
