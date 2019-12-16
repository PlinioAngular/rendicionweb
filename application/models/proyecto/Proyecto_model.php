<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Proyecto_model extends CI_Model {
 
 public function __construct() {
 parent::__construct();
 }
 
 public function mostrar()
 {
    $this->db->select('p.id_proyecto,p.codigo_proyecto,p.nombre_proyecto,c.cliente,g.gerencia,a.area,s.sub_area,t.empresa,
    c.id_cliente,g.id_gerencia,a.id_area,s.id_sub_area,t.id_empresa');
    $this->db->from("tbl_proyecto as p");
    $this->db->join("tbl_cliente as c ","p.id_cliente=c.id_cliente");
    $this->db->join("tbl_gerencia as g ","p.id_gerencia=g.id_gerencia");
    $this->db->join("tbl_area as a ","p.id_area=a.id_area");
    $this->db->join("tbl_sub_area as s ","p.id_sub_area=s.id_sub_area");
    $this->db->join("tbl_empresa as t ","p.id_empresa=t.id_empresa");
    $query=$this->db->get();      
 	return $query->result();
 }

 public function mostrar_cc()
 {
    $this->db->select('*');
    $this->db->from("tbl_proyecto as p");
    $this->db->where("p.id_centro_costo >=",1);
    $query=$this->db->get();      
 	return $query->result();
 }

 public function mostrar_por_id($id)
 {
   $this->db->select('p.id_proyecto,p.codigo_proyecto,p.nombre_proyecto,p.descripcion,c.cliente,g.gerencia,a.area,s.sub_area,t.empresa,
   c.id_cliente,g.id_gerencia,a.id_area,s.id_sub_area,t.id_empresa');
   $this->db->where('p.id_proyecto',$id);
   $this->db->from("tbl_proyecto as p");
   $this->db->join("tbl_cliente as c ","p.id_cliente=c.id_cliente");
   $this->db->join("tbl_gerencia as g ","p.id_gerencia=g.id_gerencia");
   $this->db->join("tbl_area as a ","p.id_area=a.id_area");
   $this->db->join("tbl_sub_area as s ","p.id_sub_area=s.id_sub_area");
   $this->db->join("tbl_empresa as t ","p.id_empresa=t.id_empresa");
    return $this->db->get()->row();
 }

 public function mostrar_cliente()
 {
 	$this->db->select('*');
    $this->db->from("tbl_cliente");
    $query=$this->db->get();      
 	return $query->result();
 }
 public function mostrar_gerencia()
 {
 	$this->db->select('*');
    $this->db->from("tbl_gerencia");
    $query=$this->db->get();      
 	return $query->result();
 }
 public function mostrar_area()
 {
 	$this->db->select('*');
    $this->db->from("tbl_area");
    $query=$this->db->get();      
 	return $query->result();
 }
 public function mostrar_sub_area()
 {
 	$this->db->select('*');
    $this->db->from("tbl_sub_area");
    $query=$this->db->get();      
 	return $query->result();
 }
 public function mostrar_tipo_actividad()
 {
 	$this->db->select('*');
    $this->db->from("tbl_tipo_actividad");
    $query=$this->db->get();      
 	return $query->result();
 }

 public function mostrar_clasificacion()
 {
 	$this->db->select('*');
    $this->db->from("tbl_clasificacion");
    $query=$this->db->get();      
 	return $query->result();
 }

 public function mostrar_comprobante()
 {
 	$this->db->select('*');
    $this->db->from("tblcomprobante");
    $query=$this->db->get();      
 	return $query->result();
 }

 public function mostrar_empresa()
 {
 	$this->db->select('*');
    $this->db->from("tbl_empresa");
    $query=$this->db->get();      
 	return $query->result();
 }

 public function mostrar_banco()
 {
 	$this->db->select('*');
    $this->db->from("tbl_banco");
    $query=$this->db->get();      
 	return $query->result();
 }

 function proyecto_add(){
   $detalles = array(
      'id_cliente' => $this->input->post('id_cliente'),
      'id_gerencia' => $this->input->post('id_gerencia'),
      'id_area' => $this->input->post('id_area'),
      'id_sub_area' => $this->input->post('id_sub_area'),
      'id_empresa' => $this->input->post('id_empresa'),
      'nombre_proyecto' => $this->input->post('nombre_proyecto'),
      'codigo_proyecto' => $this->input->post('codigo_proyecto'),
      'descripcion' => $this->input->post('descripcion'),
   );

   if(!$this->db->table_exists('tbl_proyecto')){ //VALIDA SI EXISTE LA TABLA
      return false;
   }
   
   $insert_fun = $this->db->insert('tbl_proyecto',$detalles);
   $insert_id = $this->db->insert_id();
   
   return $insert_id;
   
}
function proyecto_edit(){
		
   $detalles = array(
      'id_cliente' => $this->input->post('id_cliente'),
      'id_gerencia' => $this->input->post('id_gerencia'),
      'id_area' => $this->input->post('id_area'),
      'id_sub_area' => $this->input->post('id_sub_area'),
      'id_empresa' => $this->input->post('id_empresa'),
      'nombre_proyecto' => $this->input->post('nombre_proyecto'),
      'codigo_proyecto' => $this->input->post('codigo_proyecto'),
      'descripcion' => $this->input->post('descripcion'),
   );

   if(!$this->db->table_exists('tbl_proyecto')){ //VALIDA SI EXISTE LA TABLA
      return false;
   }

   if(!$this->db->update('tbl_proyecto',$detalles,array('id_proyecto' => $this->input->post('id_proyecto') ))){
      return false;
   }
   
   $update_id = $this->input->post('id_proyecto');
   return $update_id;
   
}
}