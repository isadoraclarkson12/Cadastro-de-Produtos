<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Commons_model.php');

class Produtos_model extends Commons_model
{
	public function __construct()
	{
		parent::__construct();
		$this->produto = 'produto';
	}
	public function listar(){
		$this->db->select('*');
		return $this->db->get('produto')->result();
	}
	public function buscar($id)
	{
		$this->db->select('descricao, valor, variacao_cor, cor');
		$this->db->where('id_produto', $id);
		$res = $this->db->get('produto')->result();
		if($res[0]->variacao_cor == 'S'){
			$this->db->select('descricao');
		$this->db->where('id_produto', $id);
		$res[0]->cores = $this->db->get('produto_cor')->result();
		}
		return $res;
		
	}
	public function inserir($desc, $valor, $variacao, $cvar, $svar){
		$this->db->trans_start();
	//inicio transação
		if($variacao == 1){
			$arr = array(
				'descricao' => $desc,
				'valor' => str_replace(",", ".", $valor),
				'variacao_cor' => 'N',
				'cor' => $svar[0],
				'id_situacao' => 1
			);
			$this->db->insert('produto', $arr);
		}else{
			$arr = array(
				'descricao' => $desc,
				'valor' => str_replace(",", ".", $valor),
				'variacao_cor' => 'S',
				'id_situacao' => 1
			);
			$this->db->insert('produto', $arr);
			$id = $this->db->insert_id();
			foreach ($cvar as $prod) {
				$ins = array(
					'descricao' => $prod,
					'id_produto' => $id
				);
				$this->db->insert('produto_cor', $ins);
			}
		}
		

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}
	public function alterar($id, $desc, $valor, $variacao, $cvar, $svar){
		$this->db->trans_start();
	//inicio transação
		$this->db->where_in('id_produto', $id);
		$this->db->delete('produto_cor');
		if($variacao == 1){
			$arr = array(
				'descricao' => $desc,
				'valor' => str_replace(",", ".", $valor),
				'variacao_cor' => 'N',
				'cor' => $svar[0],
				'id_situacao' => 1
			);
			$this->db->where('id_produto', $id);
			$this->db->update('produto', $arr);
		}else{
			$arr = array(
				'descricao' => $desc,
				'valor' => str_replace(",", ".", $valor),
				'variacao_cor' => 'S',
				'id_situacao' => 1
			);
			$this->db->where('id_produto', $id);
			$this->db->update('produto', $arr);
			foreach ($cvar as $prod) {
				$ins = array(
					'descricao' => $prod,
					'id_produto' => $id
				);
				$this->db->insert('produto_cor', $ins);
			}
		}
		

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}
	
}
