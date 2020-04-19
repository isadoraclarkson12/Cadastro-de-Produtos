<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Commons_model extends CI_Model
{

	protected $table;
	protected $common_errors;
	protected $return;
	protected $server_responses;

	public function __construct()
	{
		parent::__construct();
		$this->common_errors = array('000' => 'Operação realizada com sucesso',
			'100' => 'Ocorreu um erro ao consultar o banco de dados.',
			'101' => 'Não foi possivel realizar o login, usuario e/ou senhas incorreto(s).',
			'102' => 'Nenhum dado foi encontrado.');

		$this->server_responses = array('OK' => 200,
			'UNAUTHORIZED' => 401,
			'FORBIDDEN' => 403,
			'NOT_FOUND' => 404,
			'SERVER_ERROR' => 500);
		$this->return = array();
	}
    public function get_permissao($id, $modulo){
        //retorna o tipo de permissao do usuario
        $this->db->select('cadastro_cadastro_empresa.nivel, usuario.id_usuario, permissao_usuario.id_permissao_tipo');
        $this->db->from('permissao_usuario');
        $this->db->where('id_permissao_modulo', $modulo);
        $this->db->join('usuario', 'usuario.id_cadastro = '.$id);
        $this->db->join('cadastro_cadastro_empresa', 'cadastro_cadastro_empresa.id_cadastro_usuario = '.$id);
      
        $query = $this->db->get();

        return $query->result();
    }
	
	public function monta_imagem_b64($foto_base64, $id, $caminho)
	{
		$return_status = array();
		if (trim($foto_base64) == '')
		{
			$return_status['status']  = false;
			$return_status['message'] = 'É necessario enviar uma imagem!';
			$return_status['image']   = '';
			return $return_status;
		}
		$nome_arquivo = 'img_'.$id.'.jpg';
		$data = str_replace('data:image/jpeg;base64,', '', $foto_base64);
		$data = str_replace(' ', '+', $data);
		$angle = 0;
		$imageData = base64_decode($data);
		$source = imagecreatefromstring($imageData);
		$rotate = imagerotate($source, $angle, 0);
		$imageSave = imagejpeg($rotate, 'upload/'.$caminho.$nome_arquivo,100);
		imagedestroy($source);
		if ($imageSave === true)
		{
			$return_status['status']  = true;
			$return_status['message'] = 'Imagem salva com sucesso!';
			$return_status['image']   = $nome_arquivo;
		}
		else
		{
			$return_status['status']  = false;
			$return_status['message'] = 'Houve erros ao salvar a imagem!';
			$return_status['image']   = '';
		}
		return $return_status;
	}
	
	}
	?>