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
    public function listar()
    {
        // $token = parent::get_header_value('token');
        // parent::verificar_token($token); //verifica o token enviado através do header
        // $id = parent::get_payload_field('id', $token);

        $return = $this->produtos_model->listar();

        if (sizeof($return) > 0) {
        
            return parent::set_response(['status'  => true, 'message' => 'Produtos buscados com sucesso!', 'data' => $return], 200);
        }
        return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar produtos.'], 400);
        
    }
    public function inserir()
    {
        // $token = parent::get_header_value('token');
        // parent::verificar_token($token); //verifica o token enviado através do header
        // $id = parent::get_payload_field('id', $token);
        if($this->post('status') == 1){
            $return = $this->produtos_model->alterar($this->post('prod'), $this->post('descricao'), $this->post('valor'), $this->post('variacaoCor'), $this->post('color'), $this->post('wcolor'));
        }else{
            $return = $this->produtos_model->inserir($this->post('descricao'), $this->post('valor'), $this->post('variacaoCor'), $this->post('color'), $this->post('wcolor'));
        }

        

        if ($return == true) {
            if($this->post('status') == 1){
                return parent::set_response(['status'  => true, 'message' => 'Produto alterado com sucesso'], 200);
                
            }else{
                return parent::set_response(['status'  => true, 'message' => 'Produto inserido com sucesso'], 200);
            }
            
        }
        return parent::set_response(['status'  => false, 'message' => 'Erro ao inserir produto.'], 400);
    }
    public function buscar(){
        // $token = parent::get_header_value('token');
        // parent::verificar_token($token); //verifica o token enviado através do header
        // $id = parent::get_payload_field('id', $token);
        $return = $this->produtos_model->buscar($this->post('id'));

        if (sizeof($return) > 0) {
        
            return parent::set_response(['status'  => true, 'message' => 'Produto buscado com sucesso!', 'data' => $return], 200);
        }
        return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar produto.'], 400);
    }
    public function alterar(){
        // $token = parent::get_header_value('token');
        // parent::verificar_token($token); //verifica o token enviado através do header
        // $id = parent::get_payload_field('id', $token);
        $return = $this->produtos_model->alterar($this->post('prod'), $this->post('descricao'), $this->post('valor'), $this->post('variacaoCor'), $this->post('color'), $this->post('wcolor'));

        if ($return == true) {
        
            return parent::set_response(['status'  => true, 'message' => 'Produto inserido com sucesso'], 200);
        }
        return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar produtos.'], 400);
    }
    public function deletar(){
// $token = parent::get_header_value('token');
        // parent::verificar_token($token); //verifica o token enviado através do header
        // $id = parent::get_payload_field('id', $token);

         $return = $this->produtos_model->deletar($this->post('id'));

        if (sizeof($return) > 0) {
        
            return parent::set_response(['status'  => true, 'message' => 'Produto removido com sucesso'], 200);
        }
        return parent::set_response(['status'  => false, 'message' => 'Erro ao remover produto.'], 400);
    }
    
    
}
