<?php
//error_reporting(E_ERROR | E_PARSE);
error_reporting(E_ALL);
defined('BASEPATH') or exit('No direct script access allowed');

require_once 'Commons.php';

class Produtos extends Commons
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('produtos_model');
    }
    public function index_get()
    {
        $action = $this->get('action');
        $this->$action();
    }
    public function index_post()
    {
        $action = $this->get('action');
        $this->$action();
    }
    public function logar()
    {
        $return = $this->usuario_model->logar($this->post('usuario'), $this->post('senha'));

        if (sizeof($return) > 0) {
            $token = parent::gerar_jwt_geral(['id' => $return[0]->id_usuario);
            return parent::set_response(['status'  => true, 'message' => 'Login efetuado com sucesso!', 'data' => $token], 200);
        }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao encontrar usuário no banco de dados!'], 400);
        
    }
    
    
}
