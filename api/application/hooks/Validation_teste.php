<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validation extends CI_Controller {

		public $uri;
		public $current_uri;

        public function __construct(){
        	parent::__construct();
            $this->uri = new CI_URI();
        }
        
        public function validate(){
            $this->current_uri = $this->uri->segment(2)."_".$this->uri->segment(3);
            if($this->current_uri == 'clientes_login'){
            	$this->validate_cliente_login();
            }        
        }

        public function validate_cliente_login(){
        	$autenticacao = $this->input->post('autenticacao');
        	$senha        = $this->input->post('senha');
        	$message = '';
        	$status  = true;
        	if(trim($autenticacao) == ''){
        		$message .= "-Informe sua autenticacao (e-mail ou telefone)\n";
        		$status  = false;
        	}
        	if(trim($senha) == ''){
        		$message .= "-Informe sua senha";
        		$status  = false;
        	}
        	if(!$status){
        		die(json_encode(array( 'status' => false, 'message' =>  $message)));
        	}
        }

}
?>