<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/Format.php';
require APPPATH . '/libraries/REST_Controller.php';

class Restproyecto extends CI_Controller {
	use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }
	function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->__resTraitConstruct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
		$this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
		$this->load->model(array('principal/principal_model'));
 		$this->load->database('default');
    }
	public function test_get()
	{
		$array= $this->principal_model->mostrar();

		$this->response($array);
	}
}