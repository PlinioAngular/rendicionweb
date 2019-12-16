<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Principal_model extends CI_Model {
 
 public function __construct() {
 parent::__construct();
 }

 public function egresos(){
   $this->db->select('count(dc.iddetalle_costos) total,format(sum(c.tipo_cambio*dc.monto),2) as egreso');
   $this->db->from("tbldetallecostos as dc");
   $this->db->join("tblcostos as c ","dc.idcostos=c.idcostos");
   $this->db->where('c.egreso !=',0);
   $this->db->where('c.idresponsable',$this->session->userdata('id'));
   $query=$this->db->get();      
   return $query->row();
 }

 public function rendidos(){
   $this->db->select('count(dc.iddetalle_costos) total,format(sum(c.tipo_cambio*dc.monto),2) as egreso');
   $this->db->from("tbldetallecostos as dc");
   $this->db->join("tblcostos as c ","dc.idcostos=c.idcostos");
   $this->db->where('c.egreso !=',0);
   $this->db->where('dc.estado !=',0);
   $this->db->where('dc.estado !=',2);
   $this->db->where('c.idresponsable',$this->session->userdata('id'));
   $query=$this->db->get();      
   return $query->row();
 }

 public function por_rendir(){
   $this->db->select('count(dc.iddetalle_costos) total,format(sum(c.tipo_cambio*dc.monto),2) as egreso');
   $this->db->from("tbldetallecostos as dc");
   $this->db->join("tblcostos as c ","dc.idcostos=c.idcostos");
   $this->db->where('c.egreso !=',0);
   $this->db->where('dc.estado',0);
   $this->db->where('c.idresponsable',$this->session->userdata('id'));
   $query=$this->db->get();      
   return $query->row();
 }

 public function web(){
   $this->db->select('count(dc.iddetalle_costos) total,format(sum(c.tipo_cambio*dc.monto),2) as egreso');
   $this->db->from("tbldetallecostos as dc");
   $this->db->join("tblcostos as c ","dc.idcostos=c.idcostos");
   $this->db->where('c.egreso !=',0);
   $this->db->where('dc.estado',2);
   $this->db->where('c.idresponsable',$this->session->userdata('id'));
   $query=$this->db->get();      
   return $query->row();
 }
 
 public function egreso_soles(){
   $this->db->select('if(sum(dc.monto) is null,"0.00",sum(dc.monto)) as egreso');
   $this->db->from("tbldetallecostos as dc");
   $this->db->join("tblcostos as c ","dc.idcostos=c.idcostos");
   $this->db->where('c.egreso !=',0);
   $this->db->where('c.moneda','SOLES');
   $this->db->where('dc.fecha',date('Y-m-d'));
   return  $query=$this->db->get()->row();
 }

 public function egreso_dolares(){
   $this->db->select('if(sum(dc.monto) is null,"0.00",sum(dc.monto)) as egreso');
   $this->db->from("tbldetallecostos as dc");
   $this->db->join("tblcostos as c ","dc.idcostos=c.idcostos");
   $this->db->where('c.egreso !=',0);
   $this->db->where('c.moneda','DOLARES');
   $this->db->where('dc.fecha',date('Y-m-d'));
   return  $query=$this->db->get()->row();
 }

 public function ingreso_soles(){
   $this->db->select('if(sum(dc.monto) is null,"0.00",sum(dc.monto)) as ingreso');
   $this->db->from("tbldetallecostos as dc");
   $this->db->join("tblcostos as c ","dc.idcostos=c.idcostos");
   $this->db->where('c.egreso',0);
   $this->db->where('c.moneda','SOLES');
   $this->db->where('dc.fecha',date('Y-m-d'));
   return  $query=$this->db->get()->row();
 }

 public function ingreso_dolares(){
   $this->db->select('if(sum(dc.monto) is null,"0.00",sum(dc.monto)) as ingreso');
   $this->db->from("tbldetallecostos as dc");
   $this->db->join("tblcostos as c ","dc.idcostos=c.idcostos");
   $this->db->where('c.egreso',0);
   $this->db->where('c.moneda','DOLARES');
   $this->db->where('dc.fecha',date('Y-m-d'));
   return  $query=$this->db->get()->row();
 }

 
}