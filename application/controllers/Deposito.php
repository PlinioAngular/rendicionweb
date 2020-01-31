<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deposito extends CI_Controller {

	  public function __construct()
    {
		parent::__construct();
		if (!$this->session->userdata("id")) {
			redirect(base_url());
		}
		$this->load->model(array('deposito_model','proyecto/proyecto_model','principal/principal_model'));
 		$this->load->library(array('session','form_validation','encryption'));
 		$this->load->helper(array('url','form'));
		 $this->load->database('default');
		 $this->encryption->initialize(array('driver' => 'mcrypt'));
    }
	  public function index()
	  {
    $datos['notificaciones']=$this->deposito_model->mostrar();
		$datos["egresos"]=$this->principal_model->egresos();
		$datos["rendidos"]=$this->principal_model->rendidos();
		$datos["por_rendir"]=$this->principal_model->por_rendir();
    $datos["web"]=$this->principal_model->web();
    $datos['condicion']=0;
    $datos['click']=0;
    $this->load->view('layout/header',$datos);
		$this->load->view('registro/listado',$datos);
		$this->load->view('layout/footer');
    }
    public function pendiente_validacion()
	  {
    $datos['notificaciones']=$this->deposito_model->mostrar();
		$datos["egresos"]=$this->principal_model->egresos();
		$datos["rendidos"]=$this->principal_model->rendidos();
		$datos["por_rendir"]=$this->principal_model->por_rendir();
    $datos["web"]=$this->principal_model->web();
    $datos['condicion']=2;
    $datos['click']=0;
    $this->load->view('layout/header',$datos);
		$this->load->view('registro/listado',$datos);
		$this->load->view('layout/footer');
    }
    public function validas()
	  {
    $datos['notificaciones']=$this->deposito_model->mostrar();
		$datos["egresos"]=$this->principal_model->egresos();
		$datos["rendidos"]=$this->principal_model->rendidos();
		$datos["por_rendir"]=$this->principal_model->por_rendir();
    $datos["web"]=$this->principal_model->web();
    $datos['condicion']=3;
    $datos['click']=0;
    $this->load->view('layout/header',$datos);
		$this->load->view('registro/listado',$datos);
		$this->load->view('layout/footer');
    }
    public function ajax(){ 
		$data= $this->deposito_model->mostrar();
		$pasar=array();
		$i=0;$j=1;
		foreach($data as $dato){
            $estado="";
            $suma="";
            $accion="";
            if($dato->estado==0){
                $estado='<label class="form-control "style="color:white;background:red; width:100px;">Pendiente</label>';
                $suma='<input name="select[]" class="form-control form-control-sm" type="checkbox" value="'.$dato->iddetalle_Costos.'_'.$dato->monto.'_'.$dato->egreso_moneda.'"  >';
                $accion='<a href="'. base_url('deposito/registrar/').md5("div.col-sm3".$dato->iddetalle_Costos."enterprise").'" class="btn btn-info btn-circle btn-sm">
                <i class="fas fa-pen"></i></a>';
            }elseif($dato->estado==2){
                $estado='<label class="form-control "style="color:white;background:orange; width:90px;">x Validar</label>';
                $accion='<button aria-expanded="false" aria-haspopup="true" class="btn btn dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Opción</button>
                <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu">
                <a class="dropdown-item" href="'.base_url().'deposito/editar/'.md5("div.col-sm3".$dato->idrendicion."enterpriselog13").'" >Editar</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="'.base_url().'deposito/reporte/'.md5("div.col-sm3".$dato->idrendicion."enterpriselog13").'">Detalles de Rendición</a>
                </div>';
            }else{
                $estado='<label class="form-control "style="color:white;background:green; width:100px;">Validado</label>';
                $accion='<button aria-expanded="false" aria-haspopup="true" class="btn btn dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Opción</button>
                <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu">
                <a class="dropdown-item" href="'.base_url().'deposito/reporte/'.md5("div.col-sm3".$dato->idrendicion."enterpriselog13").'" >Detalles de Rendición</a>
                <div class="dropdown-divider"></div>
               
                </div>';
            }   
            $pasar[$i][0]=$dato->iddetalle_Costos;
            if($dato->estado==0){
              $pasar[$i][1]=$suma;
              $j=2;
            }
            
            
            $pasar[$i][$j]=date('Y-m-d',strtotime($dato->fecha));            
            $pasar[$i][$j+1]='<a href="#" title="'.$dato->detalle.'">'.$dato->detalle.'</a>';
            $pasar[$i][$j+2]=$dato->datos;
            $pasar[$i][$j+3]=$estado;
            $pasar[$i][$j+4]=$dato->monto;
            $pasar[$i][$j+5]=$dato->gasto;
            $pasar[$i][$j+6]='<p style="width:80px;">'.($dato->monto - $dato->gasto).'</p>';
            $pasar[$i][$j+7]=$accion;
            $i ++;
          }
          $respuesta= array(    
            'data'=>  $pasar);
          echo json_encode($respuesta);
    }
    
    public function registrar($id)
	{
    if($data['egreso']=$this->deposito_model->mostrar_egreso($id)!=null){
      if($this->deposito_model->mostrar_egreso_validar($id)==null){
          $datos['notificaciones']=$this->deposito_model->mostrar();
          $datos["egresos"]=$this->principal_model->egresos();
          $datos["rendidos"]=$this->principal_model->rendidos();
          $datos["por_rendir"]=$this->principal_model->por_rendir();
          $datos["web"]=$this->principal_model->web();
          $data['egreso']=$this->deposito_model->mostrar_egreso($id);
          $data['comprobantes']=	$this->proyecto_model->mostrar_comprobante();
          $datos['click']=1;
          $this->load->view('layout/header',$datos);
          $this->load->view('registro/registrar',$data);
          $this->load->view('layout/footer');
      }else{
        $this->load->view('layout/header');
        $this->load->view('mensajes/invalido',array("mensaje"=>"El egreso ya tiene una rendición"));
        $this->load->view('layout/footer');
      }
    }else{
      $this->load->view('layout/header');
      $this->load->view('mensajes/invalido',array("mensaje"=>""));
      $this->load->view('layout/footer');
    }
        
    }

    function upload(){
        $this->load->view('layout/header');
		$this->load->view('registro/prueba',array('error' => ' ','upload_data'=>' '));
		$this->load->view('layout/footer');
    }
/*
    public function do_upload(){
          
            
            
             * Revisamos si el archivo fue subido
             * Comprobamos si existen errores en el archivo subido
             
            $config['upload_path']          = "./";
            $config['allowed_types']        = 'gif|jpg|png|pdf';
            $config['max_size']             = 1000;
            $config['max_width']            = 1024;
            $config['max_height']           = 768;
            $config['file_name']           = 'sss';

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('userfile'))
            {
                    $error = array('error' => $this->upload->display_errors());

                    $this->load->view('registro/prueba', $error);
            }
            else
            {
                    $data = array('upload_data' => $this->upload->data());

                    $this->load->view('registro/prueba', $data);
            }
           
            // Revisamos si existe un segundo archivo
           
       
    } */

    function rendicion_add(){
		//$this->form_validation->set_rules('total','total', 'required');		
		$this->form_validation->set_rules('fechas[]','fechas[]', 'required');
		$this->form_validation->set_rules('ruc[]','ruc[]', 'required');
		$this->form_validation->set_rules('comprobantes[]','comprobantes[]', 'required');
		$this->form_validation->set_rules('serie[]','serie[]', 'required');
		$this->form_validation->set_rules('numero[]','numero[]', 'required');
		$this->form_validation->set_rules('detalles[]','detalles[]', 'required');
		$this->form_validation->set_rules('cantidad[]','cantidad[]', 'required');
		$this->form_validation->set_rules('precio[]','precio[]', 'required');
		if($this->form_validation->run() == FALSE)
		{
			echo 'Verifique que todo los camos estén llenados de manera adecuada.';
			//sleep(3); //TEST DE TIEMPO DE RESPUESTA
		}
		else
		{
			if($qid = $this->deposito_model->rendicion_add())
			{				
				echo 'si_'.md5("div.col-sm3".$qid."enterpriselog13");
			}
			else
			{
				echo 'Error en el registro. Comunicate con el administrador.';
			}
		}
  }
  public function editar($id)
	{
    if($data['egreso']=$this->deposito_model->mostrar_detalle_por_id($id)!=null){
        $datos['notificaciones']=$this->deposito_model->mostrar();
        $datos["egresos"]=$this->principal_model->egresos();
        $datos["rendidos"]=$this->principal_model->rendidos();
        $datos["por_rendir"]=$this->principal_model->por_rendir();
        $datos["web"]=$this->principal_model->web();
        $data['egreso']=$this->deposito_model->mostrar_egreso_rendicion($id);
        $data['comprobantes']=	$this->proyecto_model->mostrar_comprobante();
        $data['detalles_rendicion']=	$this->deposito_model->mostrar_detalle_por_id($id);
        $datos['click']=1;
        $this->load->view('layout/header',$datos);
		    $this->load->view('registro/editar',$data);
        $this->load->view('layout/footer');
      }else{
        $this->load->view('layout/header');
        $this->load->view('mensajes/invalido');
        $this->load->view('layout/footer');
      }
    }

    function rendicion_edit(){
      //$this->form_validation->set_rules('total','total', 'required');		
      $this->form_validation->set_rules('fechas[]','fechas[]', 'required');
      $this->form_validation->set_rules('ruc[]','ruc[]', 'required');
      $this->form_validation->set_rules('comprobantes[]','comprobantes[]', 'required');
      $this->form_validation->set_rules('serie[]','serie[]', 'required');
      $this->form_validation->set_rules('numero[]','numero[]', 'required');
      $this->form_validation->set_rules('detalles[]','detalles[]', 'required');
      $this->form_validation->set_rules('cantidad[]','cantidad[]', 'required');
      $this->form_validation->set_rules('precio[]','precio[]', 'required');
      if($this->form_validation->run() == FALSE)
      {
        echo 'Verifique que todo los camos estén llenados de manera adecuada.';
        //sleep(3); //TEST DE TIEMPO DE RESPUESTA
      }
      else
      {
        if($qid = $this->deposito_model->rendicion_edit())
        {				
          echo 'si_'.$qid;
        }
        else
        {
          echo 'Error en el registro. Comunicate con el administrador.';
        }
      }
    }


    function agregar_detalle(){
      $this->form_validation->set_rules('idrendicion','idrendicion', 'required');
      $idrendicion=$this->input->post('idrendicion');
      if($this->form_validation->run() == false)
      {
        echo 'Verifique que todo los camos estén llenados de manera adecuada.';
        //sleep(3); //TEST DE TIEMPO DE RESPUESTA
      }
      else
      {
        if($qid = $this->deposito_model->add_detalle())
        {
          echo 'si_'.$qid;
        }
        else
        {
          echo 'Error en el registro. Comunicate con el administrador.';
        }
      }
  
    }

    function eliminar_detalle(){
      $this->form_validation->set_rules('id_eliminar','id_eliminar', 'required');
      $idrendicion=$this->input->post('id_eliminar');
      if($this->form_validation->run() == false)
      {
        echo 'Verifique que todo los camos estén llenados de manera adecuada.';
        //sleep(3); //TEST DE TIEMPO DE RESPUESTA
      }
      else
      {
        if($this->deposito_model->eliminar_detalle())
        {
          echo 'si_'.$idrendicion;
        }
        else
        {
          echo 'Error en el registro. Comunicate con el administrador.';
        }
      }
  
    }

    public function suma()
	{
		if($this->input->post('select')){
			$detalles="";
			$suma=0;
			$moneda="";
			$id=$this->input->post('id_persona');
						
				$dataa=$this->input->post('select');
			if(count($dataa)!=1){	
				$iparr = explode ("_", $dataa[1]); 
				for($i=0;$i<count($dataa);$i++){
					$iparr = explode ("_", $dataa[$i]); 
					$suma+=$iparr[1];
					$detalles.=$iparr[0]."_";
					$moneda=$iparr[2];
        }
        $data['notificaciones']=$this->deposito_model->mostrar();
				$data['comprobantes']=	$this->proyecto_model->mostrar_comprobante();
				$data['suma']=$suma;
				$data['moneda']=$moneda;
        $data['seleccionados']=$detalles;
        $data['click']=1;
				$this->load->view('layout/header',$data);
				$this->load->view('registro/rendicion_suma',$data);
				$this->load->view('layout/footer');
			}
			else{
				echo "<script>alert('No debe sumar solo un monto');</script>";
			$this->index();
			}
		}else {
			echo "<script>alert('No seleccionó monto');</script>";
			$this->index();
		}
  }
  
  function rendicion_suma(){
		$this->form_validation->set_rules('fechas[]','fechas[]', 'required');
		$this->form_validation->set_rules('ruc[]','ruc[]', 'required');
		$this->form_validation->set_rules('comprobantes[]','comprobantes[]', 'required');
		$this->form_validation->set_rules('serie[]','serie[]', 'required');
		$this->form_validation->set_rules('numero[]','numero[]', 'required');
		$this->form_validation->set_rules('detalles[]','detalles[]', 'required');
		$this->form_validation->set_rules('cantidad[]','cantidad[]', 'required');
		$this->form_validation->set_rules('precio[]','precio[]', 'required');
		$proyecto=$this->input->post('cantidad');
		if($this->form_validation->run() == FALSE)
		{
			echo 'Verifique que todo los camos estén llenados de manera adecuada.';
			//sleep(3); //TEST DE TIEMPO DE RESPUESTA
		}
		else{
			$fin=0;
			$detalles=$this->input->post('id_detalle_caja');
			$filas=$this->input->post('precio');			
			$detalle=explode ("_", $detalles); 
			$datos=round((count($filas))/(count($detalle)-1));
			for($i=0;$i<count($detalle) - 1 ;$i++){
				$inicio=$i*$datos;
				
				if($i==(count($detalle)-2)){
					$fin=count($filas)-1;
				}else{
					$fin=(($i+1)*$datos)-1;
				}
				if($qid = $this->deposito_model->rendicion_add_suma($detalle[$i],$inicio,$fin))
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
  
  function reporte($id){
    if($data['egreso']=$this->deposito_model->mostrar_detalle_por_id($id)!=null){
        $datos['notificaciones']=$this->deposito_model->mostrar();
        $datos["egresos"]=$this->principal_model->egresos();
        $datos["rendidos"]=$this->principal_model->rendidos();
        $datos["por_rendir"]=$this->principal_model->por_rendir();
        $datos["web"]=$this->principal_model->web();
        $data['condicion']=$id;
        $data['egreso']=$this->deposito_model->mostrar_egreso_rendicion($id);
        $datos['click']=0;
        $this->load->view('layout/header',$datos);
		    $this->load->view('registro/reporte',$data); 
        $this->load->view('layout/footer');
      }else{
        $this->load->view('layout/header');
        $this->load->view('mensajes/invalido');
        $this->load->view('layout/footer');
      }

  }

  public function ajaxReporte(){ 
		$data= $this->deposito_model->mostrar_reporte();
		$pasar=array();
		$i=0;
		foreach($data as $dato){
           
            $pasar[$i][0]=date('Y-m-d',strtotime($dato->fecha));   
            $pasar[$i][1]=$dato->ruc;
            $pasar[$i][2]=$dato->tipo_comprobante;            
            $pasar[$i][3]=$dato->serie;
            $pasar[$i][4]=$dato->num_comprobante;
            $pasar[$i][5]=$dato->descripcion;
            $pasar[$i][6]=$dato->cantidad;
            $pasar[$i][7]=$dato->precio_unitario;
            $pasar[$i][8]=$dato->cantidad*$dato->precio_unitario;
            $i ++;
          }
          $respuesta= array(    
            'data'=>  $pasar);
          echo json_encode($respuesta);
    }

     function prueba(){
      $this->load->view('layout/header');
       $this->load->view('prueba');
       $this->load->view('layout/footer');
     }

}