<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/REST_Controller.php';

class VerficaRole extends REST_Controller
{

    public function __construct()
    {
    	parent::__construct();
    }

	public function check()
	{
       if ( isset($this->_head_args[ucfirst('token')])){
        	// Utils::getPermissoes($this->_head_args[ucfirst('token')], $this->config->item('jwt_key'))

			$token   = $this->_head_args[ucfirst('token')];
	        $key     = $this->config->item('jwt_key');
	        $payload = JWT::decode($token, $key);
	        $user_roles = $payload->roles;

			$segs = $this->uri->segment_array();
			// $segs - // pos 1 - api/
			// pos 2 - nome da classe. ex: usuarios
			// pos 3 - metodo. ex: select
			$this->config->load('roles');
			$arr_roles = $this->config->item($segs[2]);
			for( $i=0; $i<sizeof($arr_roles[$segs[3]]); $i++)
			{
				for($j=0; $j<sizeof($user_roles); $j++)
				{
					echo $arr_roles[$segs[3]][$i];
				}
			}
			// die(print_r($arr_roles[$segs[3]]));
	        // die(print_r($user_roles));
        }
         //$obj = $this->get_jwtpayload_array($token);
         //$payload->$field;
		//die(     $this->config->item('teste_role')    );
	}
}