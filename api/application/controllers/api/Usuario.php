<?php
//error_reporting(E_ERROR | E_PARSE);
error_reporting(E_ALL);
defined('BASEPATH') or exit('No direct script access allowed');

require_once 'Commons.php';

class Usuario extends Commons
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuario_model');
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
        $return = $this->usuario_model->logar($this->post('user'), hash('sha256', $this->post('password')));

        if (sizeof($return) > 0) {
            $token = parent::gerar_jwt_geral(['id' => $return[0]->id_usuario]);
            return parent::set_response(['status'  => true, 'message' => 'Login efetuado com sucesso!', 'token' => $token, 'tipo_usuario' => $return[0]->id_tipo_usuario], 200);
        }
        return parent::set_response(['status'  => false, 'message' => 'Erro ao encontrar usuário no banco de dados!'], 400);
        
    }
    public function listar()
    {
        $token = parent::get_header_value('token');
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);
        $tipo = $this->usuario_model->buscarTipo($id);
        if($tipo[0]->id_tipo_usuario == 1){
            $return = $this->usuario_model->listar();

            if (sizeof($return) > 0) {

                return parent::set_response(['status'  => true, 'message' => 'Usuários buscados com sucesso!', 'data' => $return], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar usuários.'], 400);
        }
        return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar usuários.'], 400);
    }
    public function inserir(){
     $token = parent::get_header_value('token');
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);
        $tipo = $this->usuario_model->buscarTipo($id);
        if($tipo[0]->id_tipo_usuario == 1){
            $usr = array(
                'usuario' => $this->post('usuario'),
                'senha' => hash('sha256', $this->post('senha')),
                'email' => $this->post('email'),
                'id_tipo_usuario' => $this->post('tipo_usuario'),
                'id_situacao' => 1
            );
            $cad  = array('nome' => $this->post('nome'),
                'data_nasc' => $this->post('data_nasc'),
                'rg' => $this->post('rg'),
                'cpf' => $this->post('cpf'),
                'cep' => $this->post('cep'),
                'endereco' => $this->post('endereco'),
                'complemento' => $this->post('complemento'),
                'bairro' => $this->post('bairro'),
                'cidade' => $this->post('cidade'),
                'uf' => $this->post('uf')

            );
            if($this->post('status') == 1){
                $user =  $this->usuario_model->buscarUsuario($this->post('usuario'));
                if(sizeof($user) > 0){
                    return parent::set_response(['status'  => false, 'message' => 'Usuário já existe na base de dados!'], 400);
                }else{
                    $return = $this->usuario_model->alterar($this->post('user'), $usr, $cad);
                    if ($return == true) {
                        if($this->post('status') == 1){
                            return parent::set_response(['status'  => true, 'message' => 'Usuário alterado com sucesso!'], 200);

                        }else{
                            return parent::set_response(['status'  => true, 'message' => 'Usuário inserido com sucesso!'], 200);
                        }

                    }
                }

            }else{
                $user =  $this->usuario_model->buscarUsuario($this->post('usuario'));
                if(sizeof($user) > 0){
                    return parent::set_response(['status'  => false, 'message' => 'Usuário já existe na base de dados!'], 400);
                }else{
                    $return = $this->usuario_model->inserir($usr, $cad);
                    if ($return == true) {
                        if($this->post('status') == 1){
                            return parent::set_response(['status'  => true, 'message' => 'Usuário alterado com sucesso!'], 200);

                        }else{
                            return parent::set_response(['status'  => true, 'message' => 'Usuário inserido com sucesso!'], 200);
                        }

                    }
                }
            }
        }
        return parent::set_response(['status'  => false, 'message' => 'Erro ao inserir usuário.'], 400);
    }
    public function buscar(){
     $token = parent::get_header_value('token');
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);
        $tipo = $this->usuario_model->buscarTipo($id);
        if($tipo[0]->id_tipo_usuario == 1){
            $return = $this->usuario_model->buscar($this->post('id'));

            if (sizeof($return) > 0) {

                return parent::set_response(['status'  => true, 'message' => 'Usuário buscado com sucesso!', 'data' => $return], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar usuário.'], 400);
        }
        return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar usuário.'], 400);
    }
    public function deletar(){
        $token = parent::get_header_value('token');
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);
        $tipo = $this->usuario_model->buscarTipo($id);
        if($tipo[0]->id_tipo_usuario == 1){
            $return = $this->usuario_model->deletar($this->post('id'));

            if ($return > 0) {

                return parent::set_response(['status'  => true, 'message' => 'Usuário removido com sucesso'], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao remover usuário.'], 400);
        }
        return parent::set_response(['status'  => false, 'message' => 'Erro ao remover usuário.'], 400);
    }

}
