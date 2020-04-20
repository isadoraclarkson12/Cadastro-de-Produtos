<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['404_override']                 = '';
$route['translate_uri_dashes']         = TRUE;

//rotas
$route['produtos/listar'] = 'api/produtos/produtos/action/listar';
$route['produtos/inserir'] = 'api/produtos/produtos/action/inserir';
$route['produtos/buscar'] = 'api/produtos/produtos/action/buscar';
$route['produtos/alterar'] = 'api/produtos/produtos/action/alterar';
$route['produtos/deletar'] = 'api/produtos/produtos/action/deletar';
//USUÁRIO
$route['usuario/logar'] = 'api/usuario/usuario/action/logar';
$route['usuario/listar'] = 'api/usuario/usuario/action/listar';
$route['usuario/inserir'] = 'api/usuario/usuario/action/inserir';
$route['usuario/buscar'] = 'api/usuario/usuario/action/buscar';
$route['usuario/deletar'] = 'api/usuario/usuario/action/deletar';