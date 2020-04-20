<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/REST_Controller.php';
require_once APPPATH.'libraries/Validation.php';

class Commons extends REST_Controller
{

protected $validator;
private $filesLocation;

public function __construct()
{
    $this->validator = new Validation();
    $this->filesLocation = 'upload/';
    parent::__construct();
    date_default_timezone_set('America/Sao_Paulo');
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

public function getFilesLocation()
{
    return $this->filesLocation;
}


public function set_post_args($post_array)
{
    $this->_post_args = $post_array;
}


public function gerar_jwt($arrDados)
{
    $key = $this->config->item('jwt_key');
    $payload = ['iss'   => $_SERVER['SERVER_NAME'],
    'id'    => $arrDados['id'],
    'permissoes' => $arrDados['permissoes'],
    'admin' => $arrDados['admin'],
    'usuario' => $arrDados['usuario'],
    'situacao' => $arrDados['situacao']];
    return JWT::encode($payload, $key);
}
public function gerar_jwt_geral($arrDados)
{
    $key = $this->config->item('jwt_key');
    $payload = ['iss'   => $_SERVER['SERVER_NAME'],
    'id'    => $arrDados['id']];
    return JWT::encode($payload, $key);
}
public function get_jwtpayload_obj($token)
{
    $key = $this->config->item('jwt_key');
    return JWT::decode($token, $key);
}

public function get_payload_field($field, $token)
{
    $obj = $this->get_jwtpayload_obj($token);
    return $obj->$field;
}

public function method_verificar_token($token)
{
        if(trim($token) == '')
        {
            return array('status' => false, 'message' => 'Sem permissao de acesso');
        }
        else
        {
            $payload = $this->get_jwtpayload_obj($token);
            if ((!isset($payload->iss)   || trim($payload->iss   == '')) &&
                (!isset($payload->usuario) || trim($payload->usuario == '')) &&
                (!isset($payload->id)    || trim($payload->id    == '')))
            {
                return array('status' => false, 'message' => 'Sem permissão de acesso');
            }
            else
            {
            try
            {
                AUTHORIZATION::validateToken($token);
            }
            catch(Exception $e)
            {
                return array('status' => false, 'message' =>  $e->getMessage());
            }
            return array('status' => true, 'message' => 'Válido');
        }
    }
}

public function verificar_token($token)
{
    $res = $this->method_verificar_token($token);
    if(!$res['status']){
        parent::set_response(null, REST_Controller::HTTP_UNAUTHORIZED);
        die(json_encode(array('status' => $res['status'], 'message' =>  $res['message'])));
    }
    return true;
}
public function gerar_alfa_num_token()
{
    $token = '';
    $alf   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $nums  = '123456789';
    while(strlen($token) < 6)
    {
        $tipo = rand(1,2);
        if ($tipo == 1)
        {
            $token .= substr($alf, rand(0, strlen($alf)), 1);
        }
        else
        {
            $token .= substr($nums, rand(0, strlen($nums)), 1);
        }
    }
    return $token;
}

public function get_header_value($value){
       $header = getallheaders();
       if (isset($header[$value])){
        return $header[$value];
    }
}

public function obj_array_conversion($obj)
{
    $arr = array();
    $res = get_object_vars($obj);
    foreach($res as $key => $value)
    {
        array_push($arr, $value);
    }
    return $arr;
}


}
?>