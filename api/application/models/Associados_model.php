<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Commons_model.php');

class Associados_model extends Commons_model
{
	public function __construct()
	{
		parent::__construct();
		$this->associado = 'associado';
	}
	
	public function inserirAssociado($associado, $cad_aud, $assoc_aud){
		$this->db->trans_start();
		$this->db->query("INSERT into cadastro (id_situacao, nome, cpf, rg, rg_data_expedicao, rg_orgao_emissor, ctps, pis_pasep, titulo_eleitor, titulo_eleitor_zona, titulo_eleitor_secao, titulo_data_expedicao, ctps_serie, ctps_data) VALUES(1, '".$associado['nome']."', '".$associado['cpf']."', '".$associado['rg']."', '".$associado['rg_data_expedicao']."', '".$associado['rg_orgao_emissor']."', '".$associado['ctps']."', '".$associado['pis_pasep']."', '".$associado['titulo_eleitor']."', '".$associado['titulo_eleitor_zona']."', '".$associado['titulo_eleitor_secao']."', '".$associado['titulo_data_expedicao']."', '".$associado['ctps_serie']."', '".$associado['ctps_data']."')");
		$id_cad = $this->db->insert_id();
		$cad_aud['tabela_id'] = $id_cad;
		$this->db->query("INSERT into associado (banco_conta, id_banco, banco_agencia, data_nasc, id_cadastro, codigo, id_estado_civil, sexo, id_tipo_sanguineo, id_instituicao, siape, departamento, cargo, email, id_associado_situacao, id_associado_tipo, data_associado, id_escolaridade, banco_obs, instituicao_ramal) VALUES('".$associado['banco_conta']."', ".$associado['id_banco'].", '".$associado['banco_agencia']."', '".$associado['data_nasc']."', ".$id_cad.", ".$associado['codigo'].", ".$associado['id_estado_civil'].", '".$associado['sexo']."', ".$associado['id_tipo_sanguineo'].", ".$associado['id_instituicao'].", '".$associado['siape']."', '".$associado['departamento']."', '".$associado['cargo']."', '".$associado['email']."', ".$associado['id_associado_situacao'].", ".$associado['id_associado_tipo'].", '".$associado['data_associado']."', ".$associado['id_escolaridade'].", '".$associado['obs_banco']."', '".$associado['instituicao_ramal']."')");
		$id_associado = $this->db->insert_id();
		$assoc_aud['tabela_id'] = $id_associado;
		$this->db->query("INSERT into endereco (id_cadastro, endereco, complemento, cep, id_municipio, bairro) VALUES (".$id_cad.", '".$associado['endereco']."', '".$associado['complemento']."', '".$associado['cep']."', ".$associado['id_municipio'].", '".$associado['bairro']."')");
		$this->db->insert('cadastro_auditoria', $cad_aud);
		$this->db->insert('associado_auditoria', $assoc_aud);
		if(sizeof($associado['telefones'][0]) > 0 && $associado['telefones'][0] != ""){
            for($i = 0; $i< sizeof($associado['telefones'][0]); $i++){
                $tel = explode(' ', $associado['telefones'][0][$i]);
                $arr[$i]['id_cadastro'] = $id_cad;
                $arr[$i]['ddd'] = $tel[0];
                $arr[$i]['numero'] = $tel[1];
            }
            $this->db->insert_batch('cadastro_telefone', $arr);
        }
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			
			return false;
		}
		return $id_associado;
	}
	public function retornaAssociadoTipo(){
		$this->db->select('id_associado_tipo, descricao');
			$this->db->from('associado_tipo');
			$query = $this->db->get();
			return $query->result();
	}
	public function retornaAssociadoSituacao(){
		$this->db->select('id_associado_situacao, descricao');
		$this->db->from('associado_situacao');
		$query = $this->db->get();
		return $query->result();
	}
	public function retornaInstituicao(){
		$this->db->select('instituicao.id_instituicao, cadastro.nome_fantasia');
		$this->db->join('cadastro', 'cadastro.id_cadastro = instituicao.id_cadastro');
		$this->db->from('instituicao');
		$query = $this->db->get();
		return $query->result();
	}
	public function buscarAssociado($id){
        $this->db->select('endereco.bairro, associado.banco_obs, cadastro.ctps_serie, cadastro.ctps_data, associado.data_associado, associado.id_banco, ci.nome_fantasia, ci.nome as instituicao, ci.cnpj, associado.banco_agencia, associado.instituicao_ramal, associado.banco_conta, associado.observacoes, associado.id_cadastro, associado.data_nasc, associado.sexo, associado.id_escolaridade, associado.id_tipo_sanguineo, associado.codigo, associado.id_estado_civil, associado.email, associado.id_associado_tipo, associado.id_associado_situacao, cadastro.nome, cadastro.cpf, cadastro.rg, cadastro.rg_orgao_emissor, cadastro.rg_data_expedicao, cadastro.ctps, cadastro.titulo_eleitor, cadastro.titulo_eleitor_zona, cadastro.titulo_eleitor_secao, cadastro.titulo_data_expedicao, cadastro.pis_pasep, associado.id_instituicao, endereco.endereco, endereco.complemento, endereco.cep, endereco.id_municipio, associado.siape, associado.departamento, associado.cargo');
        $this->db->join('cadastro', 'associado.id_cadastro = cadastro.id_cadastro');
		$this->db->join('endereco', 'cadastro.id_cadastro = endereco.id_cadastro');
		$this->db->join('instituicao i', 'i.id_instituicao = associado.id_instituicao');
		$this->db->join('cadastro ci', 'ci.id_cadastro = i.id_cadastro');
		$this->db->where('associado.id_associado', $id);
		$this->db->from('associado');
		$query = $this->db->get();
		return $query->result();
	}
	public function buscaBancoAssociado($id){
		$this->db->select('*');
		$this->db->where('id_banco', $id);
		$this->db->from('banco');
		$query = $this->db->get();
		return $query->result();
	}
	public function insereComplementos($pend, $ocor, $doc){
		$this->db->trans_start();
		$this->db->insert_batch('associado_ocorrencia', $ocor);
		$this->db->insert_batch('associado_pendencia', $pend);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			
			return false;
		}
		return true;
	}
	public function buscarOcorrencias($id_associado){
		$this->db->select('associado_ocorrencia.id_associado, associado_ocorrencia.id_associado_ocorrencia, associado_ocorrencia.data, ocorrencia.descricao');
		$this->db->join('ocorrencia', 'ocorrencia.id_ocorrencia = associado_ocorrencia.id_ocorrencia');
		$this->db->where('id_associado', $id_associado);
		$this->db->from('associado_ocorrencia');
		$query = $this->db->get();
		return $query->result();
	}
	public function buscarPendencias($id_associado){
		$this->db->select('associado_pendencia.id_associado, associado_pendencia.id_associado_pendencia, associado_pendencia.data, pendencia.descricao, associado_pendencia.id_pendencia_situacao');
		$this->db->join('pendencia', 'pendencia.id_pendencia = associado_pendencia.id_pendencia');
		$this->db->where('id_associado', $id_associado);
		$this->db->where('id_pendencia_situacao !=', 3);
		$this->db->from('associado_pendencia');
		$query = $this->db->get();
		return $query->result();
	}
	public function alterarSituacaoPendencia($id_pendencia_situacao, $id_associado_pendencia){
		$this->db->set('id_pendencia_situacao', $id_pendencia_situacao);
		$this->db->where('id_associado_pendencia', $id_associado_pendencia);
		$this->db->update('associado_pendencia');

		return $this->db->affected_rows();
	}
	public function alterarSituacaoDependente($id_dependente_situacao, $id_dependente){
		$this->db->set('id_dependente_situacao', $id_dependente_situacao);
		$this->db->where('id_dependente', $id_dependente);
		$this->db->update('dependente');

		return $this->db->affected_rows();
	}
	public function alterarAssociado($assoc, $cad_aud, $assoc_aud){
		$this->db->trans_start();
		// $this->db->query("UPDATE associado as a JOIN cadastro as c ON c.id_cadastro = 
		// a.id_cadastro JOIN endereco as e ON e.id_cadastro = a.id_cadastro SET 
		// c.ctps_data='".$assoc['ctps_data']."', c.ctps_serie = '".$assoc['ctps_serie']."',
		//  a.banco_obs = '".$assoc['obs_banco']."', c.nome='".$assoc['nome']."',
		//   a.data_nasc='".$assoc['data_nasc']."', a.id_estado_civil=".$assoc['id_estado_civil'].", 
		//   a.sexo='".$assoc['sexo']."', a.id_tipo_sanguineo=".$assoc['id_tipo_sanguineo'].",
		//    a.id_escolaridade=".$assoc['id_escolaridade'].", c.cpf='".$assoc['cpf']."',
		// 	c.rg='".$assoc['rg']."', c.rg_orgao_emissor='".$assoc['rg_orgao_emissor']."', 
		// 	c.rg_data_expedicao='".$assoc['rg_data_expedicao']."', c.ctps='".$assoc['ctps']."',
		// 	 c.titulo_eleitor='".$assoc['titulo_eleitor']."', 
		// 	 c.titulo_eleitor_zona='".$assoc['titulo_eleitor_zona']."', 
		// 	 c.titulo_eleitor_secao='".$assoc['titulo_eleitor_secao']."', 
		// 	 c.titulo_data_expedicao='".$assoc['titulo_data_expedicao']."', 
		// 	 c.pis_pasep='".$assoc['pis_pasep']."', a.id_instituicao=".$assoc['id_instituicao'].", 
		// 	 a.siape='".$assoc['siape']."', a.departamento='".$assoc['departamento']."', 
		// 	 a.cargo='".$assoc['cargo']."', e.cep='".$assoc['cep']."', 
		// 	 e.endereco='".$assoc['endereco']."', e.complemento='".$assoc['complemento']."', 
		// 	 e.id_municipio=".$assoc['id_municipio'].", a.email='".$assoc['email']."', 
		// 	 a.id_associado_tipo=".$assoc['id_associado_tipo'].", 
		// 	 a.id_associado_situacao=".$assoc['id_associado_situacao'].", 
		// 	 a.id_banco=".$assoc['id_banco'].", a.banco_agencia = '".$assoc['banco_agencia']."',
		// 	  a.banco_conta = '".$assoc['banco_conta']."', e.bairro = '".$assoc['bairro']."', 
		// 	  a.instituicao_ramal = '".$assoc['instituicao_ramal']."' WHERE c.id_cadastro = ".$assoc['id_cadastro']);
		//UPDATE CADASTRO
		$this->db->where('id_cadastro', $assoc['id_cadastro']);
$this->db->set('nome', $assoc['nome']);
$this->db->set('ctps_serie', $assoc['ctps_serie']);
$this->db->set('ctps', $assoc['ctps']);
$this->db->set('ctps_data', $assoc['ctps_data']);
$this->db->set('rg_orgao_emissor', $assoc['rg_orgao_emissor']);
$this->db->set('rg_data_expedicao', $assoc['rg_data_expedicao']);
$this->db->set('rg', $assoc['rg']);
$this->db->set('titulo_eleitor_zona', $assoc['titulo_eleitor_zona']);
$this->db->set('titulo_eleitor', $assoc['titulo_eleitor']);
$this->db->set('titulo_eleitor_secao', $assoc['titulo_eleitor_secao']);
$this->db->set('titulo_data_expedicao', $assoc['titulo_data_expedicao']);
$this->db->set('pis_pasep', $assoc['pis_pasep']);
$this->db->set('cpf', $assoc['cpf']);
		$this->db->update('cadastro');
//UPDATE ASSOCIADO
$this->db->where('id_cadastro', $assoc['id_cadastro']);
$this->db->set('banco_obs', $assoc['banco_obs']);
$this->db->set('data_nasc', $assoc['data_nasc']);
$this->db->set('sexo', $assoc['sexo']);
if($assoc['id_escolaridade'] != ""){
	$this->db->set('id_escolaridade', $assoc['id_escolaridade']);
}else{
	$this->db->set('id_escolaridade', null);
}
if($assoc['id_estado_civil'] != ""){
	$this->db->set('id_estado_civil', $assoc['id_estado_civil']);
}else{
	$this->db->set('id_estado_civil', null);
}
if($assoc['id_tipo_sanguineo'] != ""){
	$this->db->set('id_tipo_sanguineo', $assoc['id_tipo_sanguineo']);
}else{
	$this->db->set('id_tipo_sanguineo', null);
}

$this->db->set('departamento', $assoc['departamento']);
$this->db->set('siape', $assoc['siape']);
$this->db->set('cargo', $assoc['cargo']);
$this->db->set('id_associado_tipo', $assoc['id_associado_tipo']);
$this->db->set('id_associado_situacao', $assoc['id_associado_situacao']);
$this->db->set('id_banco', $assoc['id_banco']);
$this->db->set('banco_conta', $assoc['banco_conta']);
$this->db->set('email', $assoc['email']);
$this->db->set('instituicao_ramal', $assoc['instituicao_ramal']);
$this->db->set('id_instituicao', $assoc['id_instituicao']);
$this->db->set('observacoes', $assoc['observacoes']);
$this->db->set('data_associado', $assoc['data_associado']);
$this->db->set('banco_agencia', $assoc['banco_agencia']);
$this->db->update('associado');
//UPDATE ENDERECO
$this->db->where('id_cadastro', $assoc['id_cadastro']);
$this->db->set('endereco', $assoc['endereco']);
$this->db->set('cep', $assoc['cep']);
$this->db->set('complemento', $assoc['complemento']);
$this->db->set('id_municipio', $assoc['id_municipio']);
$this->db->update('endereco');

		$this->db->insert('cadastro_auditoria', $cad_aud);
		$this->db->insert('associado_auditoria', $assoc_aud);
		if(sizeof($assoc['telefones'][0]) > 0 && $assoc['telefones'][0] != ""){
            $this->db->where_in('id_cadastro', $assoc['id_cadastro']);
            $this->db->delete('cadastro_telefone');
            for($i = 0; $i< sizeof($assoc['telefones'][0]); $i++){
                $tel = explode(' ', $assoc['telefones'][0][$i]);
                $arr[$i]['id_cadastro'] = $assoc['id_cadastro'];
                $arr[$i]['ddd'] = $tel[0];
                $arr[$i]['numero'] = $tel[1];
            }
            $this->db->insert_batch('cadastro_telefone', $arr);
        }else{
            $this->db->where_in('id_cadastro', $assoc['id_cadastro']);
            $this->db->delete('cadastro_telefone');
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
	public function alterarDependente($dp){
		$this->db->trans_start();
		$this->db->query('UPDATE dependente as d JOIN cadastro as c ON d.id_cadastro = c.id_cadastro SET c.nome = "'.$dp['nome'].'", d.nascimento = "'.$dp['nascimento'].'", c.cpf = "'.$dp['cpf'].'", d.id_dependente_tipo = '.$dp['id_dependente_tipo'].' WHERE d.id_dependente = '.$dp['id_dependente']);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			return false;
		}
		return true;
	}
	public function inserirArquivo($arq, $id_doc){
		$this->db->set('arquivo', $arq);
		$this->db->where('id_associado_documento', $id_doc);
		$this->db->update('associado_documento');
		return $this->db->affected_rows();
	}
	public function buscaTipoSanguineo(){
		$this->db->select('id_tipo_sanguineo, descricao');
		$this->db->from('tipo_sanguineo');
		$query = $this->db->get();
		return $query->result();
	}
	public function buscaTipoDependente(){
		$this->db->select('id_dependente_tipo, descricao');
		$this->db->from('dependente_tipo');
		$query = $this->db->get();
		return $query->result();
	}
	public function buscarTodosAssociados(){
		$this->db->select('associado_situacao.descricao as descricao_situacao, cadastro.id_cadastro, associado.id_associado, cadastro.nome, associado.codigo, associado.data_nasc, municipio.nome as nome_mun, uf.sigla, associado.id_associado_situacao');
		$this->db->join('associado', 'cadastro.id_cadastro = associado.id_cadastro');
		$this->db->join('associado_situacao', 'associado.id_associado_situacao = associado_situacao.id_associado_situacao');
		$this->db->join('endereco', 'endereco.id_cadastro = cadastro.id_cadastro');
		$this->db->join('municipio', 'endereco.id_municipio = municipio.id_municipio');
		$this->db->join('uf', 'municipio.id_uf = uf.id_uf');
		$query = $this->db->get('cadastro');
		return $query->result();
	}
	public function inserirDependente($dependente){
		$this->db->trans_start();
		$this->db->query('INSERT into cadastro (nome, cpf, id_situacao) VALUES ("'.$dependente['nome'].'", "'.$dependente['cpf'].'", 1)');
		$id_cad = $this->db->insert_id();
		$this->db->query('INSERT into dependente (id_cadastro, id_associado, id_dependente_tipo, nascimento, id_dependente_situacao) VALUES ('.$id_cad.', '.$dependente['id_associado'].', '.$dependente['id_dependente_tipo'].', "'.$dependente['nascimento'].'", 1)');
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			return false;
		}
		return true;
	}
	public function buscarTodosDependentes($id_associado){
		$this->db->select('cadastro.id_cadastro, dependente.id_dependente_situacao, dependente.id_dependente, dependente.id_dependente_tipo, cadastro.nome, cadastro.cpf, dependente.nascimento, dependente_tipo.descricao as tipo');
		$this->db->join('dependente', 'cadastro.id_cadastro = dependente.id_cadastro');
		$this->db->join('associado', 'associado.id_associado = dependente.id_associado');
		$this->db->join('dependente_tipo', 'dependente_tipo.id_dependente_tipo = dependente.id_dependente_tipo');
		$this->db->where('associado.id_associado', $id_associado);
		$query = $this->db->get('cadastro');
		return $query->result();
	}
	public function buscarDocumentos($id_associado){
		$this->db->select('associado_documento.descricao, associado_documento.id_associado_documento, associado_documento.arquivo');
		$this->db->join('associado', 'associado.id_associado = associado_documento.id_associado');
		$this->db->where('associado.id_associado', $id_associado);
		$query = $this->db->get('associado_documento');
		return $query->result();
	}
	public function inserirPendencia($pendencia){
		$this->db->trans_start();
		$this->db->query('INSERT into associado_pendencia (id_associado, id_pendencia, data, id_pendencia_situacao) VALUES ('.$pendencia['id_associado'].', '.$pendencia['id_pendencia'].', "'.$pendencia['data'].'", 1)');
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			return false;
		}
		return true;
	}
	public function removerDocumento($id_associado_documento){
		$this->db->trans_start();
		$this->db->where('id_associado_documento', $id_associado_documento);
		$this->db->delete('associado_documento');
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			return false;
		}
		return true;
	}
	public function inserirDocumento($id_associado, $descricao){
		$documento = array('id_associado' => $id_associado, 'descricao' => $descricao);
		$this->db->insert('associado_documento', $documento);
		$ret['rows'] = $this->db->affected_rows();
		$ret['id'] = $this->db->insert_id();
		return $ret;
	}
	public function alterarDocumento($id_associado_documento, $descricao){
		$documento = array('id_associado_documento' => $id_associado_documento, 'descricao' => $descricao);
		$this->db->set('descricao', $documento['descricao']);
		$this->db->where('id_associado_documento', $documento['id_associado_documento']);
		$this->db->update('associado_documento');

		return $this->db->affected_rows();
	}
	public function inserirOcorrencia($ocorrencia){
		$this->db->trans_start();
		$this->db->query('INSERT into associado_ocorrencia (id_associado, id_ocorrencia, data) VALUES ('.$ocorrencia['id_associado'].', '.$ocorrencia['id_ocorrencia'].', "'.$ocorrencia['data'].'")');
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			return false;
		}
		return true;
	}
	public function buscaItensRelatorio($query){
		$query = $this->db->query($query);

		return $query->result();
	}
	public function buscaMaxCodigo(){
		$this->db->select('max(codigo) as codigo');
		$this->db->from('associado');
        $query = $this->db->get();
		return $query->result();

	}
	public function buscarNomeAssociado($nome){
		$this->db->select('c.nome, c.cpf, a.id_associado');
        $this->db->from('cadastro c');
        $this->db->join('associado a', 'c.id_cadastro = a.id_cadastro');
        $this->db->where('c.nome ilike', '%'.$nome.'%');
        $query = $this->db->get();
        return $query->result();
	}
	public function buscaLancamentos($id, $ano, $mes){
		$this->db->select('al.id_associado_convenio_lancamento, al.data_lancamento, ca.nome_fantasia, al.valor');
        $this->db->from('associado_convenio_lancamento al');
        $this->db->join('convenio c', 'c.id_convenio = al.id_convenio', 'left');
        $this->db->join('cadastro ca', 'c.id_cadastro = ca.id_cadastro', 'left');
		$this->db->where('al.mes', $mes);
		$this->db->where('al.ano', $ano);
		$this->db->where('al.id_situacao !=', 4);
		$this->db->where('al.id_associado', $id);
        $query = $this->db->get();
        return $query->result();
	}
	public function alterarSituacaoLancamento($id, $situacao){
		$this->db->set('id_situacao', $situacao);
		$this->db->where('id_associado_convenio_lancamento', $id);
		$this->db->update('associado_convenio_lancamento');

		return $this->db->affected_rows();
	}
	public function buscarConveniosFixos($id){
		$this->db->select('ca.nome_fantasia, ac.id_associado_convenio, ac.data, c.valor_lancamento');
		$this->db->from('associado_convenio ac');
		$this->db->join('convenio c', 'c.id_convenio = ac.id_convenio', 'left');
		$this->db->join('cadastro ca', 'c.id_cadastro = ca.id_cadastro', 'left');
		$this->db->where('ac.id_associado', $id);
		$this->db->where('c.id_convenio_lancamento', 2);
		$this->db->where('ac.id_situacao !=', 4);
        $query = $this->db->get();
		return $query->result();
	}
	public function buscarTodosConvFixos(){
		$this->db->select('ca.nome_fantasia, c.id_convenio, c.valor_lancamento');
		$this->db->from('convenio c');
		$this->db->join('cadastro ca', 'c.id_cadastro = ca.id_cadastro', 'left');
		$this->db->where('c.id_convenio_lancamento', 2);
		$this->db->where('c.id_situacao !=', 4);
		$this->db->where('c.id_situacao !=', 3);
        $query = $this->db->get();
		return $query->result();
	}
	public function inserirConvFixo($socio, $conv, $data){
		$this->db->set('id_associado', $socio);
		$this->db->set('id_convenio', $conv);
		$this->db->set('data', $data);
		$this->db->set('id_situacao', 1);
		$this->db->insert('associado_convenio');

		return $this->db->affected_rows();
	}
	public function alterarSituacaoConvFixo($id, $situacao){
		$this->db->set('id_situacao', $situacao);
		$this->db->where('id_associado_convenio', $id);
		$this->db->update('associado_convenio');

		return $this->db->affected_rows();
	}
	public function inserirLancamento($lanc){
		$this->db->trans_start();
		//inicio da transação
		$this->db->query('INSERT INTO convenio_lancamento_historico (id_convenio, mes, ano) VALUES('.$lanc['id_convenio'].', "'.$lanc['mes'].'", "'.$lanc['ano'].'")');
		$id = $this->db->insert_id();
		$arr = array(
			'id_convenio' => $lanc['id_convenio'],
			'ano' => $lanc['ano'],
			'mes' => $lanc['mes'],
			'valor' => str_replace(",", ".", $lanc['valor']),
			'id_convenio_lancamento_historico' => $id,
			'id_associado' => $lanc['id_associado'],
			'id_situacao' => 1,
			'data_lancamento' => date("Y-m-d")
		);
		$this->db->insert('associado_convenio_lancamento', $arr);
		//fim da transação
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
