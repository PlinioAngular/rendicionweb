<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

	public function login($username, $password){
		$this->db->select("p.datos,p.idpersona");
		$this->db->from("tblpersona as p");
		$this->db->where("p.dni", $username);
		$this->db->where("p.user_password", sha1($password));

		
		$resultados = $this->db->get();
		if ($resultados->num_rows() > 0) {
			return $resultados->row();
		}
		else{
			return false;
		}
	} 
}
