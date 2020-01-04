<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("Usuarios_model");
	}
	public function index()
	{
		if ($this->session->userdata("login")) {
			
				redirect(base_url('inicio'));
		}
		else{
			$this->load->view("layout/login");
		}
	}

	public function login(){
		if($this->input->post('username')){
			$username = $this->input->post("username");
		$password = $this->input->post("password");
		}
		else {
			$username = $this->input->get("username");
		$password = $this->input->get("password");
		}
		
		$res = $this->Usuarios_model->login($username, "123456s@731ital19*/".$password);

		if (!$res) {
			$this->session->set_flashdata("error","El usuario y/o contraseña son incorrectos");
			redirect(base_url());
		}
		else{
			$data  = array(
				'id' => $res->idpersona, 
				'nombre' => $res->datos,
				'login' => TRUE
			);
			$this->session->set_userdata($data);
			redirect(base_url());
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
