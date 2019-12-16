<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

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
		$this->load->model(array('principal/principal_model','deposito_model'));
 		$this->load->library(array('session','form_validation'));
 		$this->load->helper(array('url','form'));
 		$this->load->database('default');
    }
	public function index()
	{
			$datos['notificaciones']=$this->deposito_model->mostrar();
			$datos["egresos"]=$this->principal_model->egresos();
		$datos["rendidos"]=$this->principal_model->rendidos();
		$datos["por_rendir"]=$this->principal_model->por_rendir();
		$datos["web"]=$this->principal_model->web();	
		
		$this->load->view('layout/header',$datos);
		$this->load->view('principal/principal',$datos);
		$this->load->view('layout/footer');
	}

	


	function api()
{
	// Armamos el string de parámetros a enviar
$postData = http_build_query(array(
    'X-API-KEY' => "CCSat19*/_GrupoSatelitalTelecomunicaciones19*/"
));

$options = array('http' => array(
    'method' => 'POST',
	'header'  => 'X-API-KEY: CCSat19*/_GrupoSatelitalTelecomunicaciones19*/ ' 
));

// Creamos el contexto
$context = stream_context_create($options);

// Enviamos la solicitud
$response = file_get_contents('http://172.16.10.50/restfulcc/api/v1/listadocc', false, $context);
  //$url ='http://localhost/prueba_api/index.php/restserver/test/format/json';
  //$json = file_get_contents($url);
  var_dump($response);
  
}

}
