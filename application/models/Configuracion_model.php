<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
    class Configuracion_model extends CI_Model {
    
    public function __construct() {
    parent::__construct();
    }
    public function mostrar()
    {
        $this->db->select('*');
        $this->db->from('tblpersona');
        $this->db->where('idpersona',$this->session->userdata('id'));
        return $this->db->get()->row();

    }

    function persona_edit(){

        if($this->input->post('password')==$this->input->post('password_rep')){  
            $detalles = array(
            'user_password'=>hash("sha1",$this->input->post('password'))
            );
        
            if(!$this->db->table_exists('tblpersona')){ //VALIDA SI EXISTE LA TABLA
            return false;
            }
        
            if(!$this->db->update('tblpersona',$detalles,array('idpersona' => $this->session->userdata('id') ))){
            return false;
            }
            
            $update_id = $this->session->userdata('id');
            return $update_id;
        }
        
     }
}