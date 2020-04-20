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
	public function buscarTipo($id){
		$this->db->select('id_tipo_usuario');
		$this->db->where('id_usuario', $id);
		$this->db->where('id_situacao', 1);
		return $this->db->get('usuario')->result();
	}
	public function logar($user, $pass){
		$this->db->select('id_usuario, usuario, id_tipo_usuario');
		$this->db->where('usuario', $user);
		$this->db->where('senha', $pass);
		$this->db->where('id_situacao', 1);
		return $this->db->get('usuario')->result();
	}
	public function listar(){
		$this->db->select('c.nome, c.endereco, c.bairro, c.cep, c.complemento, c.cpf, c.rg, c.data_nasc, c.cidade, c.uf, u.usuario, u.email, tu.descricao, u.id_usuario');
		$this->db->join('cadastro c', 'u.id_cadastro = c.id_cadastro', 'left');
		$this->db->join('tipo_usuario tu', 'tu.id_tipo_usuario = u.id_tipo_usuario', 'left');
		return $this->db->get('usuario u')->result();
	}
	public function inserir($usr, $cad){
		$this->db->trans_start();
	//inicio transação
		$this->db->insert('cadastro', $cad);
		$id = $this->db->insert_id();
		$usr['id_cadastro'] = $id;
		$this->db->insert('usuario' , $usr);
		

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}
	public function buscar($id){
		$this->db->select('c.nome, c.endereco, c.bairro, c.cep, c.complemento, c.cpf, c.rg, c.data_nasc, c.cidade, c.uf, u.usuario, u.email, u.id_tipo_usuario, u.id_usuario');
		$this->db->where('u.id_usuario', $id);
		$this->db->join('cadastro c', 'u.id_cadastro = c.id_cadastro');
		return $this->db->get('usuario u')->result();

	}
	public function alterar($id, $usr, $cad){
		$this->db->trans_start();
	//inicio transação
		$this->db->where('id_usuario', $id);
		$this->db->update('usuario', $usr);

		$this->db->select('c.id_cadastro');
		$this->db->join('cadastro c', 'c.id_cadastro = u.id_cadastro');
		$this->db->where('u.id_usuario', $id);
		$u = $this->db->get('usuario u')->result();

		$this->db->where('id_cadastro', $u[0]->id_cadastro);
		$this->db->update('cadastro', $cad);

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}
	public function deletar($id){

		$this->db->select('c.id_cadastro');
		$this->db->join('cadastro c', 'c.id_cadastro = u.id_cadastro');
		$this->db->where('u.id_usuario', $id);
		$u = $this->db->get('usuario u')->result();

		$this->db->where('id_usuario', $id);
		$this->db->delete('usuario');

		$this->db->where('id_cadastro', $u[0]->id_cadastro);
		$this->db->delete('cadastro');
		

		return $this->db->affected_rows();
	}
	public function buscarUsuario($user){
		$this->db->select('*');
		$this->db->where('usuario like', $user);

		return $this->db->get('usuario')->result();
	}
	
}