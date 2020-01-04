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
        $this->db->select('dc.iddetalle_Costos,dc.fecha,dc.detalle,dc.estado,dc.monto,ca.egreso_moneda,p.datos,re.idrendicion,p.idpersona,re.gasto');
        $this->db->from('tbldetallecostos dc');
        $this->db->join('tblcostos as ca','ca.idcostos=dc.idcostos');
        $this->db->join('tblpersona as p','p.idpersona=ca.idbeneficiario');
        $this->db->join('tblrendicion as re','re.iddetalle_Costos=dc.iddetalle_Costos','left');
        $this->db->where('ca.idresponsable',$this->session->userdata('id'));
        $this->db->where('ca.egreso !=',0);
        $this->db->where('dc.estado !=',8);
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
        $this->db->where('md5(concat("div.col-sm3",dc.idrendicion,"enterpriselog13"))',$this->input->post('condicion'));
        $query=$this->db->get();
        return $query->result();
    } 

    public function mostrar_egreso($id)
    {
        $this->db->select('dc.iddetalle_Costos,dc.detalle,dc.monto,p.datos');
        $this->db->from('tbldetallecostos dc');
        $this->db->join('tblcostos ca','ca.idcostos=dc.idcostos');
        $this->db->join('tblpersona p','ca.idbeneficiario=p.idpersona');
        $this->db->where('md5(concat("div.col-sm3",dc.iddetalle_Costos,"enterprise"))',$id);
        $query=$this->db->get()->row();
        return $query;
    }

    public function mostrar_egreso_validar($id)
    {
        $this->db->select('*');
        $this->db->from('tblrendicion dc');
        $this->db->where('md5(concat("div.col-sm3",dc.iddetalle_Costos,"enterprise"))',$id);
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
        $this->db->where('md5(concat("div.col-sm3",re.idrendicion,"enterpriselog13"))',$id);
        $query=$this->db->get()->row();
        return $query;
    }

    public function mostrar_detalle_por_id($id)
      {
         $this->db->select('dr.iddetalle_rendicion,dr.fecha,dr.periodo,dr.ruc,dr.tipo_comprobante,dr.num_comprobante,dr.serie,
         dr.descripcion,dr.cantidad,dr.precio_unitario,dr.c_electronico,ce.id_electronico,ce.nombre');
         $this->db->from("tbldetallerendicion as dr");
         $this->db->where('md5(concat("div.col-sm3",r.idrendicion,"enterpriselog13"))',$id);
         $this->db->join("tblrendicion as r ","r.idrendicion=dr.idrendicion");
         $this->db->join("tbl_comprobante_electronico as ce ","ce.iddetalle_rendicion=dr.iddetalle_rendicion",'left');
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
        $nombre=$file[$i].$ruc[$i]."FE".$serie[$i].$numero[$i];
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
       $file=$this->input->post('random');
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
            $update_id2=$this->edit_detalle_rendicion($this->input->post('idrendicion'),$id_detalle,$fecha,$ruc,$comprobante,$serie,$numero,$cantidad,$precio,$descripcion,$file);
                  
         } else{
            return false;
         }
         
         $update_id = $this->input->post('idrendicion');
         return $update_id;
   }  
   }

   function getDetalle($id_detalle){
      $query=1;
         $this->db->select('*');
         $this->db->from("tbldetallerendicion as dr");
         $this->db->where('dr.iddetalle_rendicion',$id_detalle);
         $query1=$this->db->get()->row();
         if($query1){
            $query=$query1->IdDetalle_Rendicion; 
         }else{
            $query=null;
         }
              
         if($query==$id_detalle){
            return true;
         }else{
            return false;
         }
   }

   function getNombreComprobante($id_detalle){
      $query=1;
         $this->db->select('*');
         $this->db->from("tbl_comprobante_electronico as dr");
         $this->db->where('dr.iddetalle_rendicion',$id_detalle);
         $query1=$this->db->get()->row();
         if($query1){
            $query=$query1->nombre; 
         }else{
            $query=null;
         }
              
         if($query==$id_detalle){
            return true;
         }else{
            return false;
         }
   }
   
      function edit_detalle_rendicion($idrendicion,$id_detalle,$fecha,$ruc,$comprobante,$serie,$numero,$cantidad,$precio,$descripcion,$file){
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
         if($this->getDetalle($id_detalle[$i])){
            if(!$this->db->update('tbldetallerendicion',$data,array('iddetalle_rendicion' => $id_detalle[$i] ))){
               return false;
            }
            $update_id = $id_detalle[$i] ;
         }else{
            $det=explode("_",$id_detalle[$i]);
            if(count($det)!=2){
               $update_id=$this->add_detalle($idrendicion,$fecha[$i],$ruc[$i],$comprobante[$i],$serie[$i],$numero[$i],$descripcion[$i],$cantidad[$i],$precio[$i],$file[$i]);
            }else{
               $this->eliminar_detalle($det[0]);
               $update_id=$det[0];
            }
            
         }    
      }
      return $update_id;
   }

   

   function add_detalle($idrendicion,$fecha,$ruc,$comprobante,$serie,$numero,$descripcion,$cantidad,$precio,$file){
      $insert_id=0;
      $data = array(
         'idrendicion' => $idrendicion,
         'fecha' => $fecha,
         'ruc' => $ruc,
         'tipo_comprobante' => $comprobante,
         'serie' => $serie,
         'num_comprobante' => $numero,
         'descripcion' => $descripcion,
         'cantidad' => $cantidad,
         'precio_unitario' => $precio,
         'c_electronico' => $file
      );
   
      if(!$this->db->table_exists('tbldetallerendicion')){ //VALIDA SI EXISTE LA TABLA
         return false;
      }
      $nombre=$file.$ruc."FE".$serie.$numero;
      $insert_fun = $this->db->insert('tbldetallerendicion',$data);
      $insert_id = $this->db->insert_id(); 
      if($insert_id){
         $this->cargar($insert_id,$nombre,$file);
      } 
      return $insert_id;
   }

   function eliminar_detalle($id_detalle){
      return $this->db->delete('tbldetallerendicion', array('IdDetalle_Rendicion' => $id_detalle));
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
      $nombre=$file[$i].$ruc[$i]."FE".$serie[$i].$numero[$i];
      if($insert_id){
            $this->cargar($insert_id,$nombre,$file[$i]);
         } 
      }
      return $insert_id;
   }


}