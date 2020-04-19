<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Commons_model.php');

class Usuario_model extends Commons_model
{
	public function __construct()
	{
		parent::__construct();
		$this->usuario = 'usuario';
	}

	public function logar($user, $pass){
		$this->db->select('id_usuario, usuario, id_tipo_usuario');
		$this->db->where('usuario', $user);
		$this->db->where('senha', $pass);
		$this->db->where('id_situacao', 1);
		return $this->db->get('usuario')->result();
	}
	
	}