<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
    class Deposito_model extends CI_Model {
    
    public function __construct() {
    parent::__construct();
    }
    public function mostrar()
    {
        $this->db->select('dc.iddetalle_Costos,dc.fecha,dc.detalle,dc.estado,dc.monto,ca.egreso_moneda,p.datos,re.idrendicion,p.idpersona');
        $this->db->from('tbldetallecostos dc');
        $this->db->join('tblcostos as ca','ca.idcostos=dc.idcostos');
        $this->db->join('tblpersona as p','p.idpersona=ca.idbeneficiario');
        $this->db->join('tblrendicion as re','re.iddetalle_Costos=dc.iddetalle_Costos','left');
        $this->db->where('ca.idresponsable',$this->session->userdata('id'));
        $this->db->where('ca.egreso !=',0);
        if($this->input->post('condicion')=="0"){
         $this->db->where('dc.estado',0);
        }
        if($this->input->post('condicion')=="2"){
         $this->db->where('dc.estado',2);
        }
        if($this->input->post('condicion')=="3"){
         $this->db->where('dc.estado !=',0);
         $this->db->where('dc.estado !=',2);
        }
        $this->db->order_by("dc.iddetalle_Costos","desc");
        $query=$this->db->get();
        return $query->result();
    } 

    public function mostrar_reporte()
    {
        $this->db->select('*');
        $this->db->from('tbldetallerendicion dc');
        $this->db->where('md5(dc.idrendicion)',$this->input->post('condicion'));
        $query=$this->db->get();
        return $query->result();
    } 

    public function mostrar_egreso($id)
    {
        $this->db->select('dc.iddetalle_Costos,dc.detalle,dc.monto,p.datos');
        $this->db->from('tbldetallecostos dc');
        $this->db->join('tblcostos ca','ca.idcostos=dc.idcostos');
        $this->db->join('tblpersona p','ca.idresponsable=p.idpersona');
        $this->db->where('md5(dc.iddetalle_Costos)',$id);
        $query=$this->db->get()->row();
        return $query;
    }

    public function mostrar_egreso_rendicion($id)
    {
        $this->db->select('dc.iddetalle_Costos,dc.detalle,dc.monto,p.datos,re.idrendicion,re.gasto');
        $this->db->from('tbldetallecostos dc');
        $this->db->join('tblcostos ca','ca.idcostos=dc.idcostos');
        $this->db->join('tblpersona p','ca.idresponsable=p.idpersona');
        $this->db->join('tblrendicion re','dc.iddetalle_Costos=re.iddetalle_Costos');
        $this->db->where('md5(re.idrendicion)',$id);
        $query=$this->db->get()->row();
        return $query;
    }

    public function mostrar_detalle_por_id($id)
      {
         $this->db->select('dr.iddetalle_rendicion,dr.fecha,dr.periodo,dr.ruc,dr.tipo_comprobante,dr.num_comprobante,dr.serie,
         dr.descripcion,dr.cantidad,dr.precio_unitario,dr.c_electronico');
         $this->db->from("tbldetallerendicion as dr");
         $this->db->where('md5(r.idrendicion)',$id);
         $this->db->join("tblrendicion as r ","r.idrendicion=dr.idrendicion");
         $query=$this->db->get();      
         return $query->result();
      }

    function rendicion_add(){
        $fecha=$this->input->post('fechas');
        $ruc=$this->input->post('ruc');
        $comprobante=$this->input->post('comprobantes');
        $serie=$this->input->post('serie');
        $numero=$this->input->post('numero');
        $cantidad=$this->input->post('cantidad');
        $precio=$this->input->post('precio');
        $descripcion=$this->input->post('detalles');
        $file=$this->input->post("random");
       $detalle = array(
          'idusuario' =>$this->session->userdata('id'),
          'gasto' => $this->input->post('total'),
          'iddetalle_Costos' => $this->input->post('iddetalle_Costos'),
          'idcostos' => '1000',
          'fecha' => date('Y-m-d\TH:i:s.u')
       );
    
       if(!$this->db->table_exists('tblrendicion')){ //VALIDA SI EXISTE LA TABLA
          return false;
       }
       if(count($precio)>0){
       $insert_fun = $this->db->insert('tblrendicion',$detalle);
       $insert_id = $this->db->insert_id();
       if($insert_id){
          $insert_id1=$this->add_detalle_rendicion($insert_id,$fecha,$ruc,$comprobante,$serie,$numero,$cantidad,$precio,$descripcion,$file);
          $this->cambio_estado($this->input->post('iddetalle_Costos'));
       }
       return $insert_id;
    }
    else { return false;}
    }

    
    
    function add_detalle_rendicion($idrendicion,$fecha,$ruc,$comprobante,$serie,$numero,$cantidad,$precio,$descripcion,$file){
        $insert_id=0;
        $nombre=null;
        for($i=0;$i<count($precio);$i++){
        $data = array(
           'idrendicion' => $idrendicion,
           'fecha' => $fecha[$i],           
           'ruc' => $ruc[$i],
           'tipo_comprobante' => $comprobante[$i],
           'serie' => $serie[$i],
           'num_comprobante' => $numero[$i],
           'descripcion' => $descripcion[$i],
           'cantidad' => $cantidad[$i],
           'precio_unitario' => $precio[$i],
           'c_electronico'=>$file[$i]
        );
     
        if(!$this->db->table_exists('tbldetallerendicion')){ //VALIDA SI EXISTE LA TABLA
           return false;
        }
        $nombre=$file[$i].$ruc[$i].$comprobante[$i].$serie[$i].$numero[$i];
        $insert_fun = $this->db->insert('tbldetallerendicion',$data);
        $insert_id = $this->db->insert_id(); 
         if($insert_id){
           
            $this->cargar($insert_id,$nombre,$file[$i]);
           
         }
        }
        return $insert_id;
     }

     public function cargar($id,$nombre,$file){                     
      /*
       * Revisamos si el archivo fue subido
       * Comprobamos si existen errores en el archivo subido
       */
      //mkdir("./comprobante/".$id,0700);
      $config['upload_path']          = "./comprobantes/";
      $config['allowed_types']        = 'gif|jpg|png|pdf';
      $config['max_size']             = 1000;
      $config['max_width']            = 1024;
      $config['max_height']           = 768;
      $config['file_name']           = $nombre;
      $ruta="userfile".$file;  
      
      $this->load->library('upload');
      $this->upload->initialize($config,true);
      if (  $this->upload->do_upload($ruta))
      {
         $this->add_c_electronico($id,$nombre);
      }
      else
      {
              return false;
              $config=null;
      }
      $config=null;
     
   }

   function add_c_electronico($id,$nombre){
      $data = array(
         'iddetalle_rendicion' => $id,
         'hora' => date('Y-m-d\TH:i:s.u'), 
         'nombre'=>$nombre          
         
      );
   
      if(!$this->db->table_exists('tbl_comprobante_electronico')){ //VALIDA SI EXISTE LA TABLA
         return false;
      }
      
      $insert_fun = $this->db->insert('tbl_comprobante_electronico',$data);
      $insert_id = $this->db->insert_id(); 
      return $insert_id;
    }

     function cambio_estado($id_detalle){ 
           
        $data = array(
           'estado' =>2
           
        );
     
        if(!$this->db->table_exists('tbldetallecostos')){ //VALIDA SI EXISTE LA TABLA
            return false;
        }           
        if(!$this->db->update('tbldetallecostos',$data,array('iddetalle_Costos' => $id_detalle ))){
            return false;
        }
        
        $update_id = $this->input->post('iddetalle_Costos');
        return $update_id;
    }

    function rendicion_edit(){   
      $update_id2;
      $id_detalle=$this->input->post('iddetalle_rendicion');
      $fecha=$this->input->post('fechas');
       $ruc=$this->input->post('ruc');
       $comprobante=$this->input->post('comprobantes');
       $serie=$this->input->post('serie');
       $numero=$this->input->post('numero');      
       $cantidad=$this->input->post('cantidad');
       $precio=$this->input->post('precio');
       $descripcion=$this->input->post('detalles');
      $detalle = array(
         'idusuario' =>$this->session->userdata('id'),
         'gasto' => $this->input->post('total'),
         'fecha' => date('Y-m-d\TH:i:s.u')
      );
   
      if(!$this->db->table_exists('tblrendicion')){ //VALIDA SI EXISTE LA TABLA
         return false;
      }
      if(count($precio)>0){
         if($this->db->update('tblrendicion',$detalle,array('idrendicion' => $this->input->post('idrendicion') ))){
            $update_id2=$this->edit_detalle_rendicion($id_detalle,$fecha,$ruc,$comprobante,$serie,$numero,$cantidad,$precio,$descripcion);
                  
         } else{
            return false;
         }
         
         $update_id = $this->input->post('idrendicion');
         return $update_id;
   }  
   }
   
      function edit_detalle_rendicion($id_detalle,$fecha,$ruc,$comprobante,$serie,$numero,$cantidad,$precio,$descripcion){
         $update_id;
         for($i=0;$i<count($precio);$i++){
          $data = array(
         'fecha' => $fecha[$i],         
         'ruc' => $ruc[$i],
         'tipo_comprobante' => $comprobante[$i],
         'serie' => $serie[$i],
         'num_comprobante' => $numero[$i],
         'descripcion' => $descripcion[$i],
         'cantidad' => $cantidad[$i],
         'precio_unitario' => $precio[$i]
      );
   
         if(!$this->db->table_exists('tbldetallerendicion')){ //VALIDA SI EXISTE LA TABLA
            return false;
         }   
      
         if(!$this->db->update('tbldetallerendicion',$data,array('iddetalle_rendicion' => $id_detalle[$i] ))){
            return false;
         }
         
         $update_id = $id_detalle[$i] ;
      }
      return $update_id;
   }

   

   function add_detalle(){
      $insert_id=0;
      $data = array(
         'idrendicion' => $this->input->post('idrendicion'),
         'fecha' => date("Y/m/d"),
         'ruc' => 0,
         'idcomprobante' => 1,
         'serie' => '',
         'num_comprobante' => '',
         'descripcion' => '',
         'cantidad' => 0,
         'precio' => 0
      );
   
      if(!$this->db->table_exists('tbldetallerendicion')){ //VALIDA SI EXISTE LA TABLA
         return false;
      }
      
      $insert_fun = $this->db->insert('tbldetallerendicion',$data);
      $insert_id = $this->db->insert_id(); 
      
      return $insert_id;
   }

   function eliminar_detalle(){
      return $this->db->delete('tbldetallerendicion', array('iddetalle_rendicion' => $this->input->post('id_eliminar')));
   }

   function rendicion_add_suma($id_detalle,$inicio,$fin){
      $suma=0;   
      $fecha=$this->input->post('fechas');
      $ruc=$this->input->post('ruc');
      $comprobante=$this->input->post('comprobantes');
      $serie=$this->input->post('serie');
      $numero=$this->input->post('numero');
      $cantidad=$this->input->post('cantidad');
      $precio=$this->input->post('precio');
      $file=$this->input->post("random");
      for($i=$inicio;$i<=$fin;$i++){
         $suma+=round(($precio[$i]*$cantidad[$i]),2);
      }
      $descripcion=$this->input->post('detalles');
     $detalle = array(
        'id_registra' =>$this->session->userdata('id'),
        'gasto' => $suma,
        'iddetalle_Costos' => $id_detalle,
        'fecha_registro' => date('Y-m-d\TH:i:s.u')
     );
   
     if(!$this->db->table_exists('tblrendicion')){ //VALIDA SI EXISTE LA TABLA
        return false;
     }if(count($precio)>0){
      $insert_fun = $this->db->insert('tblrendicion',$detalle);
      $insert_id = $this->db->insert_id();
      if($insert_id){         
         $insert_id1=$this->add_detalle_rendicion_suma($inicio,$fin,$insert_id,$fecha,$ruc,$comprobante,$serie,$numero,$cantidad,$precio,$descripcion,$file);
         $this->cambio_estado($id_detalle);
      }
      return $insert_id;
   }
   else { return false;}
   
   }
   
   function add_detalle_rendicion_suma($inicio,$fin,$idrendicion,$fecha,$ruc,$comprobante,$serie,$numero,$cantidad,$precio,$descripcion,$file){
      $insert_id=0;
      for($i=$inicio;$i<=$fin;$i++){
      $data = array(
         'idrendicion' => $idrendicion,
         'fecha' => $fecha[$i],
         'ruc' => $ruc[$i],
         'idcomprobante' => $comprobante[$i],
         'serie' => $serie[$i],
         'num_comprobante' => $numero[$i],
         'descripcion' => $descripcion[$i],
         'cantidad' => $cantidad[$i],
         'precio' => $precio[$i]
      );
   
      if(!$this->db->table_exists('tbldetallerendicion')){ //VALIDA SI EXISTE LA TABLA
         return false;
      }
      
      $insert_fun = $this->db->insert('tbldetallerendicion',$data);
      $insert_id = $this->db->insert_id();
      if($insert_id){
            $this->cargar($insert_id,$nombre,$file[$i]);
         } 
      }
      return $insert_id;
   }


}