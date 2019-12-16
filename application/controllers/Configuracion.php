<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracion extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
		parent::__construct();
		if (!$this->session->userdata("id")) {
			redirect(base_url());
		}
		$this->load->model(array('configuracion_model','principal/principal_model','deposito_model'));
 		$this->load->library(array('session','form_validation','encryption'));
 		$this->load->helper(array('url','form'));
		 $this->load->database('default');
		 $this->encryption->initialize(array('driver' => 'mcrypt'));
    }

    function index(){
		$datos['notificaciones']=$this->deposito_model->mostrar();
		$datos["egresos"]=$this->principal_model->egresos();
		$datos["rendidos"]=$this->principal_model->rendidos();
		$datos["por_rendir"]=$this->principal_model->por_rendir();
    	$datos["web"]=$this->principal_model->web();
        $datos['datos']=$this->configuracion_model->mostrar();
        $this->load->view('layout/header',$datos);
		$this->load->view('configuracion/datos',$datos);
		$this->load->view('layout/footer');
    }

    function persona_edit(){

		$this->form_validation->set_rules('password_rep','apellidopassword_rep_paterno', 'required');
		$this->form_validation->set_rules('password','password', 'required');
		$this->form_validation->set_rules('password_ant','password_ant', 'required');
		
		if($this->form_validation->run() == FALSE)
		{
			echo 'Verifique que todo los campos estén llenados de manera adecuada.';
			//sleep(3); //TEST DE TIEMPO DE RESPUESTA
		}
		else
		{
			if($qid = $this->configuracion_model->persona_edit())
			{
				echo 'si_'.$qid;
			}
			else
			{
				echo 'Error en el registro. Comunicate con el administrador.';
			}
		}
	}
}