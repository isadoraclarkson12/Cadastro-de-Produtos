<?php
error_reporting(E_ERROR | E_PARSE);
//error_reporting(E_ALL);
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/autoload.php';
require_once 'Commons.php';

use Mpdf\Mpdf;

class Associados extends Commons
{
    public $tk = 'token';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('associados_model');
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
    public function inserirAssociado()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
		$permissao_tipo = $permissao[0]->id_permissao_tipo;
		$usuario = $permissao[0]->id_usuario;
        if ($permissao_nivel == 0 || $permissao_tipo == 2) {
            $assoc = $this->post('associado');
            if ($assoc['titulo_data_expedicao'] != null && $assoc['titulo_data_expedicao'] != "") {
                $assoc['titulo_data_expedicao'] = parent::dateConvert($assoc['titulo_data_expedicao']);
            } else {
                $assoc['titulo_data_expedicao'] = "0000-00-00";
            }

            if ($assoc['rg_data_expedicao'] != null && $assoc['rg_data_expedicao'] != "") {
                $assoc['rg_data_expedicao'] = parent::dateConvert($assoc['rg_data_expedicao']);
            } else {
                $assoc['rg_data_expedicao'] = "0000-00-00";
            }
            if ($assoc['data_nasc'] != null && $assoc['data_nasc'] != "") {
                $assoc['data_nasc'] = parent::dateConvert($assoc['data_nasc']);
            } else {
                $assoc['data_nasc'] = "0000-00-00";
            }
            if ($assoc['data_associado'] != null && $assoc['data_associado'] != "") {
                $assoc['data_associado'] = parent::dateConvert($assoc['data_associado']);
            } else {
                $assoc['data_associado'] = "0000-00-00";
            }
            if ($assoc['ctps_data'] != null && $assoc['ctps_data'] != "") {
                $assoc['ctps_data'] = parent::dateConvert($assoc['ctps_data']);
            } else {
                $assoc['ctps_data'] = "0000-00-00";
            }
            if($assoc['id_tipo_sanguineo'] == "" || $assoc['id_tipo_sanguineo'] == null){
                $assoc['id_tipo_sanguineo'] = "null";
            }
			$cad_aud = array(
				'id_usuario_login' => $usuario,
				'acao' => 'I',
				'tabela' => 'associado',
				'coluna' => '{nome: '.$assoc['nome'].', cpf: '.$assoc['cpf'].', rg: '.$assoc['rg'].', rg_data_expedicao: '.$assoc['rg_data_expedicao'].', rg_orgao_emissor: '.$assoc['rg_orgao_emissor'].', ctps: '.$assoc['ctps'].', pis_pasep: '.$assoc['pis_pasep'].', titulo_eleitor: '.$assoc['titulo_eleitor'].', titulo_eleitor_zona: '.$assoc['titulo_eleitor_zona'].', titulo_eleitor_secao: '.$assoc['titulo_eleitor_secao'].', titulo_data_expedicao: '.$assoc['titulo_data_expedicao'].', nome_anterior: '.$assoc['nome_anterior'].', ctps_serie: '.$assoc['ctps_serie'].', ctps_data: '.$assoc['ctps_data'].'}'
			);
			$assoc_aud = array(
				'id_usuario_login' => $usuario,
				'acao' => 'I',
				'tabela' => 'associado',
				'coluna' => '{banco_conta: '.$assoc['banco_conta'].', id_banco: '.$assoc['id_banco'].', banco_agencia: '.$assoc['banco_agencia'].', data_nasc: '.$assoc['data_nasc'].', codigo: '.$assoc['codigo'].', id_estado_civil: '.$assoc['id_estado_civil'].', sexo: '.$assoc['sexo'].', id_tipo_sanguineo: '.$assoc['id_tipo_sanguineo'].', id_instituicao: '.$assoc['id_instituicao'].', siape: '.$assoc['siape'].', departamento: '.$assoc['departamento'].', cargo: '.$assoc['cargo'].', email: '.$assoc['email'].', id_associado_situacao: 1, id_associado_tipo: '.$assoc['id_associado_tipo'].', data_associado: '.$assoc['data_associado'].', id_escolaridade: '.$assoc['id_escolaridade'].', obs_banco: '.$assoc['obs_banco'].', instituicao_ramal: '.$assoc['instituicao_ramal'].'}'
			);
            $return = $this->associados_model->inserirAssociado($assoc, $cad_aud, $assoc_aud);

            if ($return != false) {
                $token = parent::gerar_jwt_geral(['id' => $return]);
                return parent::set_response(['status'  => true, 'message' => 'Dados inseridos com sucesso!', 'data' => $token], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao inserir dados!'], 400);
        }
    }
    public function alterarAssociado()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
		$permissao_tipo = $permissao[0]->id_permissao_tipo;
		$usuario = $permissao[0]->id_usuario;
        if ($permissao_nivel == 0 || $permissao_tipo == 2) {
			$assoc = $this->post('associado');
			$payload = JWT::decode($assoc['id_associado'], $this->config->item('jwt_key'));
			$id_socio = $payload->id;
            if ($assoc['titulo_data_expedicao'] != null && $assoc['titulo_data_expedicao'] != "") {
                $assoc['titulo_data_expedicao'] = parent::dateConvert($assoc['titulo_data_expedicao']);
            } else {
                $assoc['titulo_data_expedicao'] = "0000-00-00";
            }

            if ($assoc['rg_data_expedicao'] != null && $assoc['rg_data_expedicao'] != "") {
                $assoc['rg_data_expedicao'] = parent::dateConvert($assoc['rg_data_expedicao']);
            } else {
                $assoc['rg_data_expedicao'] = "0000-00-00";
            }
            if ($assoc['data_nasc'] != null && $assoc['data_nasc'] != "") {
                $assoc['data_nasc'] = parent::dateConvert($assoc['data_nasc']);
            } else {
                $assoc['data_nasc'] = "0000-00-00";
            }
            if ($assoc['data_associado'] != null && $assoc['data_associado'] != "") {
                $assoc['data_associado'] = parent::dateConvert($assoc['data_associado']);
            } else {
                $assoc['data_associado'] = "0000-00-00";
            }
            if ($assoc['ctps_data'] != null && $assoc['ctps_data'] != "") {
                $assoc['ctps_data'] = parent::dateConvert($assoc['ctps_data']);
            } else {
                $assoc['ctps_data'] = "0000-00-00";
            }
            
			$cad_aud = array(
				'id_usuario_login' => $usuario,
				'acao' => 'I',
				'tabela' => 'associado',
				'tabela_id' => $assoc['id_cadastro'],
				'coluna' => '{nome: '.$assoc['nome'].', cpf: '.$assoc['cpf'].', rg: '.$assoc['rg'].', rg_data_expedicao: '.$assoc['rg_data_expedicao'].', rg_orgao_emissor: '.$assoc['rg_orgao_emissor'].', ctps: '.$assoc['ctps'].', pis_pasep: '.$assoc['pis_pasep'].', titulo_eleitor: '.$assoc['titulo_eleitor'].', titulo_eleitor_zona: '.$assoc['titulo_eleitor_zona'].', titulo_eleitor_secao: '.$assoc['titulo_eleitor_secao'].', titulo_data_expedicao: '.$assoc['titulo_data_expedicao'].', nome_anterior: '.$assoc['nome_anterior'].', ctps_serie: '.$assoc['ctps_serie'].', ctps_data: '.$assoc['ctps_data'].'}'
			);
			$assoc_aud = array(
				'id_usuario_login' => $usuario,
				'acao' => 'I',
				'tabela' => 'associado',
				'tabela_id' => $id_socio,
				'coluna' => '{banco_conta: '.$assoc['banco_conta'].', id_banco: '.$assoc['id_banco'].', banco_agencia: '.$assoc['banco_agencia'].', data_nasc: '.$assoc['data_nasc'].', codigo: '.$assoc['codigo'].', id_estado_civil: '.$assoc['id_estado_civil'].', sexo: '.$assoc['sexo'].', id_tipo_sanguineo: '.$assoc['id_tipo_sanguineo'].', id_instituicao: '.$assoc['id_instituicao'].', siape: '.$assoc['siape'].', departamento: '.$assoc['departamento'].', cargo: '.$assoc['cargo'].', email: '.$assoc['email'].', id_associado_situacao: 1, id_associado_tipo: '.$assoc['id_associado_tipo'].', data_associado: '.$assoc['data_associado'].', id_escolaridade: '.$assoc['id_escolaridade'].', obs_banco: '.$assoc['obs_banco'].', instituicao_ramal: '.$assoc['instituicao_ramal'].'}'
			);
            $return = $this->associados_model->alterarAssociado($assoc, $cad_aud, $assoc_aud);
            if ($return != false) {
                return parent::set_response(['status'  => true, 'message' => 'Dados inseridos com sucesso!'], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao inserir dados!'], 400);
        }
    }
    public function uploadArquivos()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2) {
            $payload = JWT::decode($this->post('file-up'), $this->config->item('jwt_key'));
            $doc = $this->associados_model->inserirDocumento($payload->id, $this->post('descricao'));

            if ($doc['rows'] > 0) {

                if ($_FILES['file']['size'] != 0) {
                    $ret = parent::envia_arquivo($_FILES['file'], $doc['id'], 'upload/Documentos/');

                    if ($ret == false) {
                        return parent::set_response(['status'  => false, 'message' => 'Erro ao salvar arquivo'], 400);
                    }
                    $resp = $this->associados_model->inserirArquivo($ret, $doc['id']);
                    if (sizeof($resp > 0)) {
                        return parent::set_response(['status'  => true, 'message' => 'Arquivo enviado com sucesso!'], 200);
                    }
                    return parent::set_response(['status'  => false, 'message' => 'Erro ao inserir no banco de dados'], 400);
                }
                return parent::set_response(['status'  => true, 'message' => 'Dados inseridos com sucesso!'], 200);
            }
        }
        return parent::set_response(['status'  => false, 'message' => 'Erro ao inserir no banco de dados'], 400);
    }
    public function alterarDocumento()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $usuario = $permissao[0]->id_usuario;
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2) {

            if ($this->post('descricao') != null && $this->post('descricao') != "") {
                $return = $this->associados_model->alterarDocumento($this->post('file-up'), $this->post('descricao'));
            }
            $ret = parent::envia_arquivo($_FILES['file'], $this->post('file-up'), 'upload/Documentos/');
            if ($ret == false) {
                return parent::set_response(['status'  => false, 'message' => 'Erro ao salvar arquivo'], 400);
            }
            $resp = $this->associados_model->inserirArquivo($ret, $this->post('file-up'));
            if (sizeof($return) > 0 || sizeof($resp) > 0) {
                return parent::set_response(['status'  => true, 'message' => 'Dados inseridos com sucesso!'], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao inserir no banco dados!'], 400);
        }
    }
    public function montaRelatorio($status, $query, $param)
    {
        $itens = $this->associados_model->buscaItensRelatorio($query);

        if ($status == true) {
            for ($i = 0; $i < sizeof($itens); $i++) {
                $arr[$i] = $itens[$i]->id_cadastro;
            }

            $tel = $this->associados_model->buscaTelefones($arr);

            for ($i = 0; $i < sizeof($itens); $i++) {
                $k = 0;
                for ($j = 0; $j < sizeof($tel); $j++) {
                    if ($tel[$j]->id_cadastro == $itens[$i]->id_cadastro) {
                        if ($tel[$j]->numero != "") {
                            $itens[$i]->telefones[$k] = '(' . $tel[$j]->ddd . ')' . $tel[$j]->numero;
                            $k++;
                        }
                    }
                }
            }
        }

        for ($i = 0; $i < sizeof($itens); $i++) {
            $html .= '<tr>';
            if ($param['seq'] != false) {
                $html .= '<td style="padding-bottom:4px;padding-top:4px">' . ($i + 1) . '</td>';
            }
            if (array_key_exists('codigo', $itens[$i])) {
                $html .= '<td style="padding-bottom:4px;padding-top:4px">' . $itens[$i]->codigo . '</td>';
            }

            if (array_key_exists('nome', $itens[$i])) {
                $html .= '<td style="padding-bottom:4px;padding-top:4px">' . $itens[$i]->nome . '</td>';
            }
            if (array_key_exists('cpf', $itens[$i])) {
                $html .= '<td style="padding-bottom:4px;padding-top:4px">' . $itens[$i]->cpf . '</td>';
            }
            if (array_key_exists('endereco', $itens[$i])) {
                $html .= '<td style="padding-bottom:4px;padding-top:4px">' . $itens[$i]->endereco . '</td>';
            }
            if (array_key_exists('email', $itens[$i])) {
                $html .= '<td style="padding-bottom:4px;padding-top:4px">' . $itens[$i]->email . '</td>';
            }
            if (array_key_exists('situacao', $itens[$i])) {
                $html .= '<td style="padding-bottom:4px;padding-top:4px">' . $itens[$i]->situacao . '</td>';
            }
            if (array_key_exists('nome_fantasia', $itens[$i])) {
                $html .= '<td style="padding-bottom:4px;padding-top:4px">' . $itens[$i]->nome_fantasia . '</td>';
            }
            
            if ($status == true) {
                $html .= '<td colspan="1" style="padding-bottom:4px;padding-top:4px; width:20%">';
                if (sizeof($itens[$i]->telefones) > 0) {
                    
                         
                        for ($j = 0; $j < sizeof($itens[$i]->telefones); $j++) {
                            if ($j != sizeof($itens[$i]->telefones) - 1) {
                                $html .= $itens[$i]->telefones[$j] . ' / ';
                            } else {
                                
                                $html .= $itens[$i]->telefones[$j];
                            }
                        }
                    
                }
                $html .= '</td>';
            }
            if ($param['ass'] != false) {
                $html .= '<td colspan="1" style="padding-bottom:4px;padding-top:4px;">______________________________________</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</table>';

        return $html;
    }
    public function gerarRelatorio()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $usuario = $permissao[0]->id_usuario;
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2 || $permissao_tipo == 1) {
            $query2 = 'select a.id_cadastro, ';
            $c = 0;
            $sq = false;
            $html = '<div style="border-top:1px solid silver;border-bottom:1px solid silver; padding:15px;text-align:center"><span style="font-size:20px">' . $this->post('titulo') . '</span></div><table id="t_rel"><tr style="border: 1px solid black;">';
            if ($this->post('seq') != "") {
                $sq = true;
                $html .= '<th style="background-color:silver;padding:10px">Seq.</th>';
            }
            if ($this->post('campo_codigo') != "") {
                $html .= '<th style="background-color:silver;padding:10px">Código</th>';
                $query .= 'a.codigo';
                $c++;
            }
            if ($this->post('campo_nome') != "") {
                $html .= '<th style="background-color:silver;padding:10px">Nome</th>';
                if ($c > 0) {
                    $query .= ', c.nome';
                } else {
                    $query .= 'c.nome';
                }
                $c++;
            }
            if ($this->post('campo_cpf') != "") {
                $html .= '<th style="background-color:silver;padding:10px">CPF</th>';
                if ($c > 0) {
                    $query .= ', c.cpf';
                } else {
                    $query .= 'c.cpf';
                }
                $c++;
            }
            if ($this->post('campo_endereco') != "") {
                $html .= '<th style="background-color:silver;padding:10px">Endereço</th>';
                if ($c > 0) {
                    $query .= ', e.endereco';
                } else {
                    $query .= 'e.endereco';
                }
                $c++;
            }
            if ($this->post('campo_email') != "") {
                $html .= '<th style="background-color:silver;padding:10px">E-mail</th>';
                if ($c > 0) {
                    $query .= ', a.email';
                } else {
                    $query .= 'a.email';
                }
                $c++;
            }
            if ($this->post('campo_situacao') != "") {
                $html .= '<th style="background-color:silver;padding:10px">Situação</th>';
                if ($c > 0) {
                    $query .= ', aas.descricao as situacao';
                } else {
                    $query .= 'aas.descricao as situacao';
                }
                $c++;
            }
            if ($this->post('campo_instituicao') != "") {
                $html .= '<th style="background-color:silver;padding:10px">Instituição</th>';
                if ($c > 0) {
                    $query .= ', ci.nome_fantasia';
                } else {
                    $query .= 'ci.nome_fantasia';
                }
                $c++;
            }


            $query .= ' from associado a join associado_situacao aas on aas.id_associado_situacao = a.id_associado_situacao join cadastro c on c.id_cadastro = a.id_cadastro join endereco e on e.id_cadastro = a.id_cadastro join instituicao i on i.id_instituicao = a.id_instituicao join cadastro ci on ci.id_cadastro = i.id_cadastro';
            if ($this->post('situacao') == 0) {
                if ($this->post('instituicao') != 0) {
                    $query .= ' WHERE a.id_instituicao = ' . $this->post('instituicao');
                    if ($this->post('dt_ref') != null && $this->post('dt_ref') != "") {
                        $query .= ' AND a.data_associado <= "' . $this->post('dt_ref') . '"';
                    }
                } else {
                    if ($this->post('dt_ref') != null && $this->post('dt_ref') != "") {
                        $query .= ' WHERE a.data_associado <= "' . $this->post('dt_ref') . '"';
                    }
                }
            } else {
                $query .= ' WHERE a.id_associado_situacao = ' . $this->post('situacao');
                if ($this->post('instituicao') != 0) {
                    $query .= ' AND a.id_instituicao = ' . $this->post('instituicao');
                    if ($this->post('dt_ref') != null && $this->post('dt_ref') != "") {
                        $query .= ' AND a.data_associado <= "' . $this->post('dt_ref') . '"';
                    }
                } else {
                    if ($this->post('dt_ref') != null && $this->post('dt_ref') != "") {
                        $query .= ' AND a.data_associado <= "' . $this->post('dt_ref') . '"';
                    }
                }
            }
            if ($this->post('ordem') != 0) {
                if ($this->post('ordem') == 1) {
                    $query .= ' ORDER BY c.nome';
                } else {
                    $query .= ' ORDER BY a.codigo';
                }
            }
            if ($this->post('campo_telefone') != "") {
                $html .= '<th style="background-color:silver;padding:10px">Telefone</th>';
                $status = true;
            } else {
                $status = false;
            }
            if ($c > 0) {
                $query = $query2 . $query;
            } else {
                $query = 'SELECT a.id_cadastro ' . $query;
            }
            $as = false;
            if ($this->post('assinatura') != "") {
                $as = true;
                $html .= '<th style="background-color:silver;padding:10px">Assinatura</th>';
            }
            $param['seq'] = $sq;
            $param['ass'] = $as;

            $r_corpo = $this->montaRelatorio($status, $query, $param);
            $html .= '</tr>' . $r_corpo;

            $file = APPPATH . '..\upload\Relatorios\relatorio_geral.pdf';
            $permissao = chmod(APPPATH . "..\upload\Relatorios", 777);
            $res = unlink($file);
            $mpdf = new mPDF();
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->SetHTMLHeader('
<div style="text-align: left; font-weight: bold;">
    <img src="upload/Relatorios/logo-name.png" style="width:20%; padding-bottom:20px">
</div>');
            $mpdf->SetHTMLFooter('
<table width="100%">
    <tr>
        <td width="33%" style="font-size:12px;text-align:left">Emitido em {DATE j/m/Y}</td>
        <td width="33%" style="text-align: right;font-size:12px">Página {PAGENO}/{nbpg}</td>
    </tr>
</table>');
            $mpdf->WriteHTML($html);

            $mpdf->Output('upload/Relatorios/relatorio_geral.pdf', \Mpdf\Output\Destination::FILE);

            if (file_exists('upload/Relatorios/relatorio_geral.pdf')) {
                return parent::set_response(['status'  => true, 'message' => 'Relatório gerado com sucesso!', 'link' => 'upload/Relatorios/relatorio_geral.pdf'], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao gerar relatório!'], 400);
        }
    }
    public function corpoAutorizacaoConta($socio)
    {
        $html = '<br><br><br><br><br><br><br><br><div><span>À<br>' . $socio[0]->banco . '<br>A/C GERÊNCIA<br>NESTA</span><br><br><br>
        <p>Prezados Senhores,</p><br><br>
        <span>Venho pelo presente, autorizar V. S. DEBITAR em minha conta corrente nº ' . $socio[0]->banco_conta . ' e agência ' . $socio[0]->banco_agencia . ' à CRÉDITO DA ASMED - Associação dos Servidores das Instituições, Órgãos e Empresas Públicas Federais de Uberaba, conta corrente nº ' . $socio[0]->conta_asmed . ', no dia do recebimento de meus proventos, a Importância Consignada e relativa ao cartão Valecard, Cantina, Manutenção de clubes, Mensalidade, Dentista. Autorizo ainda que, na falta de saldo suficiente, o débito poderá ser parcial, até o limite de meu saldo credor existente na referida conta corrente.</span><br><br>
        <p>Por ser verdade assino a presente autorização.</p><br><br>
        
        <p style="text-align:center">Uberaba, _______ de ______________________________________ de _________________</p><br><br><br>
        
        <p style="text-align:center">_________________________________________________________</p>
        <p style="text-align:center">(Assinatura)</p>
        <p style="text-align:center">Nome: ' . $socio[0]->nome . '</p>
        <p style="text-align:center">CPF: ' . $socio[0]->cpf . '</p></div>';

        return $html;
    }
    public function gerarDescontoConta()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2 || $permissao_tipo == 1) {

            $payload = JWT::decode($this->post('id_associado'), $this->config->item('jwt_key'));
            $id = $payload->id;
            $socio = $this->associados_model->buscarAssociado($id);
            $banco = $this->associados_model->buscaBancoAssociado($socio[0]->id_banco);
            $socio[0]->banco = $banco[0]->nome;
            $socio[0]->conta_asmed = $banco[0]->conta_asmed;
            $html = $this->corpoAutorizacaoConta($socio);
            $file = APPPATH . '..\upload\Relatorios\autorizacao_debito.pdf';
            $permissao = chmod(APPPATH . "..\upload\Relatorios", 777);
            $res = unlink($file);
            $mpdf = new mPDF();
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->SetHTMLHeader('
            <div style="border-bottom:2px solid green"><table><tr>
            <td><img src="upload/Relatorios/Logo.png" style="width:10%; padding-bottom:20px"></td>
            <td align="center"><p style="font-size:20px">Associação dos Servidores das Instituições, Órgãos e Empresas Públicas Federais de Uberaba - ASMED</p></td></tr>
            <tr><td colspan="2" align="center"><span>(LEI Nº 3.027 - Utilidade Pública)</span></td></tr><tr>
            <td colspan="2" align="center"><span>contato@asmed.com.br</span></td></tr></table></div><div style="border-top:1px solid green; margin-top:3px; margin-bottom:20px"><table width="100%"><tr><td align="left" style="padding-top: 5px"><span>CNPJ Nº 20.052.635/0001-40</span></td><td align="right" style="padding-top: 5px"><span style="text-right">INSC. ESTADUAL - ISENTA</span></td></tr></table></div>');
            $mpdf->SetHTMLFooter('
            <div style="border-top:1px solid green"><p style="font-size:10px;text-align:center; font-family:Times, "Times New Roman", Georgia, serif;">Av. Getúlio Guarita, 95 Bairro Abadia - CEP 38025-440 tel.3317-1020 - Uberaba - MG</p></div>');
            $mpdf->WriteHTML($html);

            $mpdf->Output('upload/Relatorios/autorizacao_debito.pdf', \Mpdf\Output\Destination::FILE);

            if (file_exists('upload/Relatorios/autorizacao_debito.pdf')) {
                return parent::set_response(['status'  => true, 'message' => 'Relatório gerado com sucesso!', 'link' => 'upload/Relatorios/autorizacao_debito.pdf'], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao gerar relatório!'], 400);
        }
    }
    public function termoPermanencia()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $usuario = $permissao[0]->id_usuario;
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2 || $permissao_tipo == 1) {

            $payload = JWT::decode($this->post('id_associado'), $this->config->item('jwt_key'));
            $id = $payload->id;
            $socio = $this->associados_model->buscarAssociado($id);
            $banco = $this->associados_model->buscaBancoAssociado($socio[0]->id_banco);
            $socio[0]->banco = $banco[0]->nome;
            $socio[0]->conta_asmed = $banco[0]->conta_asmed;
            $html = $this->termoCorpo($socio);
            $file = APPPATH . '..\upload\Relatorios\termoPerm.pdf';
            $permissao = chmod(APPPATH . "..\upload\Relatorios", 777);
            $res = unlink($file);
            $mpdf = new mPDF();
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->SetHTMLHeader('
            <div style="border-bottom:2px solid green"><table><tr>
            <td><img src="upload/Relatorios/Logo.png" style="width:10%; padding-bottom:20px"></td>
            <td align="center"><p style="font-size:20px">Associação dos Servidores das Instituições, Órgãos e Empresas Públicas Federais de Uberaba - ASMED</p></td></tr>
            <tr><td colspan="2" align="center"><span>(LEI Nº 3.027 - Utilidade Pública)</span></td></tr><tr>
            <td colspan="2" align="center"><span>contato@asmed.com.br</span></td></tr></table></div><div style="border-top:1px solid green; margin-top:3px; margin-bottom:20px"><table width="100%"><tr><td align="left" style="padding-top: 5px"><span>CNPJ Nº 20.052.635/0001-40</span></td><td align="right" style="padding-top: 5px"><span style="text-right">INSC. ESTADUAL - ISENTA</span></td></tr></table></div>');
            $mpdf->SetHTMLFooter('
            <div style="border-top:1px solid green"><p style="font-size:10px;text-align:center; font-family:Times, "Times New Roman", Georgia, serif;">Av. Getúlio Guarita, 95 Bairro Abadia - CEP 38025-440 tel.3317-1020 - Uberaba - MG</p></div>');
            $mpdf->WriteHTML($html);

            $mpdf->Output('upload/Relatorios/termoPerm.pdf', \Mpdf\Output\Destination::FILE);

            if (file_exists('upload/Relatorios/termoPerm.pdf')) {
                return parent::set_response(['status'  => true, 'message' => 'Relatório gerado com sucesso!', 'link' => 'upload/Relatorios/termoPerm.pdf'], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao gerar relatório!'], 400);
        }
    }
    public function termoCorpo($socio)
    {
        $tel = $this->associados_model->buscaTelefones($socio[0]->id_cadastro);
        if (sizeof($tel) > 1) {
            $k = 0;
            $num = '';
            for ($j = 0; $j < sizeof($tel); $j++) {

                if ($tel[$j]->numero != "") {
                    $socio[0]->telefones[$k] = '(' . $tel[$j]->ddd . ')' . $tel[$j]->numero;
                    $k++;
                }
            }
            if (sizeof($socio[0]->telefones) > 1) {
                for ($i = 0; $i < sizeof($socio[0]->telefones); $i++) {
                    if ($i != sizeof($socio[0]->telefones) - 1) {
                        $num = $socio[0]->telefones[$i] . ' / ';
                    } else {
                        $num = $socio[0]->telefones[$i];
                    }
                }
            } else {
                $num = '<span style="font-size:12px">______________________________________</span>';
            }
        } else {
            $num = '<span style="font-size:12px">______________________________________</span>';
        }

        $html = '<div style="margin-top:30px"><br><br><br><br><br><br><br><br><br><p style="font-size:16px; font-weight:700;text-align:center";font-family:Times, "Times New Roman", Georgia, serif;><strong>TERMO DE PERMANÊNCIA DE ASSOCIADO</strong></p></div><br><br><br>
        <p style="text-align:justify">Eu, ' . $socio[0]->nome . ', portador do RG nº ' . $socio[0]->rg . ' inscrito no CPF sob o nº ' . $socio[0]->cpf . ', residente e domiciliado nesta cidade de Uberaba - MG, no Endereço: ' . $socio[0]->endereco . ', Bairro: ' . $socio[0]->bairro . ', CEP: ' . $socio[0]->cep . ', telefone(s) ' . $num . ' associado da ASSOCIAÇÃO DOS SERVIDORES DAS INSTITUIÇÕES, ÓRGÃOS E EMPRESAS PÚBLICAS FEDERAIS DE UBERABA - ASMED, pessoa jurídica de direito privado, inscrita no CNPJ sob o nº 20.052.635/0001-40, com sede nesta cidade de Uberaba - MG, na Avenida Getúlio Guaritá, nº 95, CEP 38.025-440 desde ____/____/______ , DECLARO para todos os fins de direito que tenho o interesse em permanecer na condição de associado, não obstante o encerramento do vínculo empregatício mantido com a ' . $socio[0]->instituicao . ', inscrita no CNPJ sob o nº ' . $socio[0]->cnpj .
            '</p><p style="text-align:justify">Na oportunidade, assumo a responsabilidade de proceder ao pagamento mensal da contribuição prevista no artigo 9º do estatuto, no importe de R$ __________ mensais, a ser paga até o dia 10 do mês subsequente ao vencido, perante a tesouraria da associação e contra recibo.<br>
        </p><p style="text-align:justify">Por fim, declaro ter conhecimento de que a manutenção da minha condição de associado após o final do vínculo empregatício está condicionada à aprovação por meio de referendo em Assembleia Geral Extraordinária e ao regular e tempestivo pagamento da contribuição associativa, conforme o artigo 6º do estatuto.</p><br>
        <p style="text-align:center">Por ser verdade firma o presente.</p><br><br>
        <p style="text-align:center">Uberaba, __________ de ______________________________ de ____________.</p><br><br>
        <p style="text-align:center"> ______________________________________________________________</p>
        <p style="text-align:center"> Assinatura</p>';

        return $html;
    }
    public function gerarDescontoFolha()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2 || $permissao_tipo == 1) {

            $payload = JWT::decode($this->post('id_associado'), $this->config->item('jwt_key'));
            $id = $payload->id;
            $socio = $this->associados_model->buscarAssociado($id);

            $html = $this->corpoAutorizacaoFolha($socio);
            $file = APPPATH . '..\upload\Relatorios\autorizacao_folha.pdf';
            $permissao = chmod(APPPATH . "..\upload\Relatorios", 777);
            $res = unlink($file);
            $mpdf = new mPDF();
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->SetHTMLHeader('
            <div style="border-bottom:2px solid green"><table><tr>
            <td><img src="upload/Relatorios/Logo.png" style="width:10%; padding-bottom:20px"></td>
            <td align="center"><p style="font-size:20px">Associação dos Servidores das Instituições, Órgãos e Empresas Públicas Federais de Uberaba - ASMED</p></td></tr>
            <tr><td colspan="2" align="center"><span>(LEI Nº 3.027 - Utilidade Pública)</span></td></tr><tr>
            <td colspan="2" align="center"><span>contato@asmed.com.br</span></td></tr></table></div><div style="border-top:1px solid green; margin-top:3px; margin-bottom:20px"><table width="100%"><tr><td align="left" style="padding-top: 5px"><span>CNPJ Nº 20.052.635/0001-40</span></td><td align="right" style="padding-top: 5px"><span style="text-right">INSC. ESTADUAL - ISENTA</span></td></tr></table></div>');
            $mpdf->SetHTMLFooter('
            <div style="border-top:1px solid green"><p style="font-size:10px;text-align:center; font-family:Times, "Times New Roman", Georgia, serif;">Av. Getúlio Guarita, 95 Bairro Abadia - CEP 38025-440 tel.3317-1020 - Uberaba - MG</p></div>');
            $mpdf->WriteHTML($html);

            $mpdf->Output('upload/Relatorios/autorizacao_folha.pdf', \Mpdf\Output\Destination::FILE);

            if (file_exists('upload/Relatorios/autorizacao_folha.pdf')) {
                return parent::set_response(['status'  => true, 'message' => 'Relatório gerado com sucesso!', 'link' => 'upload/Relatorios/autorizacao_folha.pdf'], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao gerar relatório!'], 400);
        }
    }
    public function corpoAutorizacaoFolha($socio)
    {
        $html = '<div><br><br><br><br><br><br><p style="font-size:16px; font-weight:700;text-align:center";font-family:Times, "Times New Roman", Georgia, serif;><strong>AUTORIZAÇÃO</strong></p></div><br><br><br>
        <span style="font-family:Times, "Times New Roman", Georgia, serif; font-size:13px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Autorizo o Departamento Pessoal da <strong>' . $socio[0]->nome_fantasia . '</strong> (' . $socio[0]->instituicao . ')
        a descontar em folha de pagamento mensalmente, o valor correspondente a 1% (um por cento) dos meus vencimentos/remuneração,
        a favor da <strong>ASMED</strong> (Associação dos Servidores das Instituições, Órgãos e Empresas Públicas Federais de Uberaba), que
        serão utilizados para pagamento de minha mensalidade junto a mesma.</span><br><br><p>Por ser verdade firmo a presente autorização.</p><br><br>
        <p style="text-align:center">Uberaba, __________ de ______________________________ de ____________.</p>
        <p>Nome: ' . $socio[0]->nome . '</p>
        <p>Conta Corrente nº: ' . $socio[0]->banco_conta . ' Agência: ' . $socio[0]->banco_agencia . '</p>
        <p>CPF: ' . $socio[0]->cpf . ' RG: ' . $socio[0]->rg . '</p>
        <p>Assinatura: _______________________________________________________________________</p>';

        return $html;
    }
    public function buscaMaxCodigo()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2 || $permissao_tipo == 1) {
            $return = $this->associados_model->buscaMaxCodigo();
            if (sizeof($return) > 0) {
                return parent::set_response(['status'  => true, 'message' => 'Busca realizada com sucesso!', 'data' => $return], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar no banco de dados!'], 400);
        }
    }
    public function buscarTodosAssociados()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2 || $permissao_tipo == 1) {
            $return = $this->associados_model->buscarTodosAssociados();
            if (sizeof($return) > 0) {
                for ($i = 0; $i < sizeof($return); $i++) {
                    //formata data
                    $return[$i]->token = parent::gerar_jwt_geral(['id' => $return[$i]->id_associado]);
                    $return[$i]->data_nasc = parent::dateLocal($return[$i]->data_nasc);
                }
                return parent::set_response(['status'  => true, 'message' => 'Busca realizada com sucesso!', 'data' => $return], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar no banco de dados!'], 400);
        }
    }
    public function buscaMunicipios()
    {
        $mun = $this->associados_model->buscaMunicipios();
        if (sizeof($mun) > 0) {
            return parent::set_response(['status'  => true, 'message' => 'Busca realizada com sucesso!', 'data' => $mun], 200);
        }
        return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar no banco de dados!'], 400);
    }

    public function buscaTipoSanguineo()
    {
        $result = $this->associados_model->buscaTipoSanguineo();
        if (sizeof($result) > 0) {
            return parent::set_response(['status'  => true, 'message' => 'Busca realizada com sucesso!', 'data' => $result], 200);
        }
        return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar no banco de dados!'], 400);
    }
    public function removerDocumento()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2) {
            $doc = $this->post('documento');
            $file = APPPATH . "..\upload\Documentos\/" . $doc['arquivo'] . ".jpg";
            $permissao = chmod(APPPATH . "..\upload\Documentos", 777);
            $res = unlink($file);
            $return = $this->associados_model->removerDocumento($doc['id_associado_documento']);
            if ($return == true) {
                return parent::set_response(['status'  => true, 'message' => 'Dados deletados com sucesso!'], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao remover dados!'], 400);
        }
    }
    public function buscaTipoDependente()
    {
        $result = $this->associados_model->buscaTipoDependente();
        if (sizeof($result) > 0) {
            return parent::set_response(['status'  => true, 'message' => 'Busca realizada com sucesso!', 'data' => $result], 200);
        }
        return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar no banco de dados!'], 400);
    }
    public function retornaAssociadoTipo()
    {
        $result = $this->associados_model->retornaAssociadoTipo();
        if (sizeof($result) > 0) {
            return parent::set_response(['status'  => true, 'message' => 'Busca realizada com sucesso!', 'data' => $result], 200);
        }
        return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar no banco de dados!'], 400);
    }
    public function retornaInstituicao()
    {
        $result = $this->associados_model->retornaInstituicao();
        if (sizeof($result) > 0) {
            return parent::set_response(['status'  => true, 'message' => 'Busca realizada com sucesso!', 'data' => $result], 200);
        }
        return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar no banco de dados!'], 400);
    }
    public function retornaAssociadoSituacao()
    {
        $result = $this->associados_model->retornaAssociadoSituacao();
        if (sizeof($result) > 0) {
            return parent::set_response(['status'  => true, 'message' => 'Busca realizada com sucesso!', 'data' => $result], 200);
        }
        return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar no banco de dados!'], 400);
    }
    public function alterarDependente()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2) {
            $return = $this->associados_model->alterarDependente($this->post('dependente'));
            if ($return != false) {
                return parent::set_response(['status'  => true, 'message' => 'Dados inseridos com sucesso!'], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao inserir no banco de dados!'], 400);
        }
    }
    public function alterarSituacaoDependente()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token);
        $id = parent::get_payload_field('id', $token);
        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2) {
            $return = $this->associados_model->alterarSituacaoDependente($this->post('id_dependente_situacao'), $this->post('id_dependente'));
            if (sizeof($return) > 0) {
                return parent::set_response(['status'  => true, 'message' => 'Situacao alterada com sucesso!'], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao inserir dados!'], 400);
        }
    }
    public function inserirDependente()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2) {
            $dp = $this->post('dependente');
            $payload = JWT::decode($dp['id_associado'], $this->config->item('jwt_key'));
            $dp['id_associado'] = $payload->id;
            $return = $this->associados_model->inserirDependente($dp);
            if ($return == true) {
                return parent::set_response(['status'  => true, 'message' => 'Dados inseridos com sucesso!'], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao inserir no banco de dados!'], 400);
        }
    }
    public function buscarTodosDependentes()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2 || $permissao_tipo == 1) {
            $payload = JWT::decode($this->post('id_associado'), $this->config->item('jwt_key'));
            $return = $this->associados_model->buscarTodosDependentes($payload->id);
            if (sizeof($return) > 0) {
                return parent::set_response(['status'  => true, 'message' => 'Busca realizada com sucesso!', 'data' => $return], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar no banco de dados!'], 400);
        }
    }
    public function buscarDocumentos()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2 || $permissao_tipo == 1) {
            $payload = JWT::decode($this->post('id_associado'), $this->config->item('jwt_key'));
            $return = $this->associados_model->buscarDocumentos($payload->id);
            if (sizeof($return) > 0) {
                return parent::set_response(['status'  => true, 'message' => 'Busca realizada com sucesso!', 'data' => $return], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar no banco de dados!'], 400);
        }
    }
    public function inserirPendencia()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2) {
            $dados = $this->post('dados');
            $payload = JWT::decode($dados['id_associado'], $this->config->item('jwt_key'));
            $dados['id_associado'] = $payload->id;
            $return = $this->associados_model->inserirPendencia($dados);
            if ($return != false) {
                return parent::set_response(['status'  => true, 'message' => 'Dados inseridos com sucesso!'], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao inserir no banco de dados!'], 400);
        }
    }
    public function inserirOcorrencia()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2) {
            $dados = $this->post('dados');
            $payload = JWT::decode($dados['id_associado'], $this->config->item('jwt_key'));
            $dados['id_associado'] = $payload->id;

            $return = $this->associados_model->inserirOcorrencia($dados);
            if ($return != false) {
                return parent::set_response(['status'  => true, 'message' => 'Dados inseridos com sucesso!'], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao inserir no banco de dados!'], 400);
        }
    }
    public function buscarOcorrenciasPendencias()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2 || $permissao_tipo == 1) {
            $payload = JWT::decode($this->post('id_associado'), $this->config->item('jwt_key'));
            $tk = $payload->id;
            $ocorrencias = $this->associados_model->buscarOcorrencias($tk);
            $pendencias = $this->associados_model->buscarPendencias($tk);
            if (sizeof($ocorrencias) > 0 || sizeof($pendencias) > 0) {
                return parent::set_response(['status'  => true, 'message' => 'Busca realizada com sucesso!', 'ocorrencias' => $ocorrencias, 'pendencias' => $pendencias], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar no banco de dados!'], 400);
        }
    }
    public function alterarSituacaoPendencia()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token);
        $id = parent::get_payload_field('id', $token);
        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2) {
            $return = $this->associados_model->alterarSituacaoPendencia($this->post('id_pendencia_situacao'), $this->post('id_associado_pendencia'));
            if (sizeof($return) > 0) {
                return parent::set_response(['status'  => true, 'message' => 'Situacao alterada com sucesso!'], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao inserir no banco de dados!'], 400);
        }
    }
    public function buscarNomeAssociado()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2 || $permissao_tipo == 1) {
            $return = $this->associados_model->buscarNomeAssociado($this->post('nome'));
            
            if (sizeof($return) > 0) {
                for ($i = 0; $i < sizeof($return); $i++) {
                    $return[$i]->link = '../associado/?id='.parent::gerar_jwt_geral(['id' => $return[$i]->id_associado]);
                }
                return parent::set_response(['status'  => true, 'message' => 'Busca realizada com sucesso!', 'data' => $return], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar no banco de dados!'], 400);
        }
    }
    
    public function buscarAssociado()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2 || $permissao_tipo == 1) {
            $payload = JWT::decode($this->post('id_associado'), $this->config->item('jwt_key'));
            $tk = $payload->id;
            $return = $this->associados_model->buscarAssociado($tk);
            $return[0]->data_associado = parent::dateLocal($return[0]->data_associado);
            $return[0]->data_nasc = parent::dateLocal($return[0]->data_nasc);
            $return[0]->ctps_data = parent::dateLocal($return[0]->ctps_data);
            $return[0]->titulo_data_expedicao = parent::dateLocal($return[0]->titulo_data_expedicao);
            $return[0]->rg_data_expedicao = parent::dateLocal($return[0]->rg_data_expedicao);
            $tel = $this->associados_model->buscaTelefones($return[0]->id_cadastro);

            if (sizeof($return) > 0) {
                return parent::set_response(['status'  => true, 'message' => 'Busca realizada com sucesso!', 'data' => $return, 'tel' => $tel], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar no banco de dados!'], 400);
        }
    }
    public function buscaLancamentos()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2 || $permissao_tipo == 1) {
            $payload = JWT::decode($this->post('id_associado'), $this->config->item('jwt_key'));
            $id = $payload->id;
            $return = $this->associados_model->buscaLancamentos($id, $this->post('ano'), $this->post('mes'));


            if (sizeof($return) > 0) {
                return parent::set_response(['status'  => true, 'message' => 'Busca realizada com sucesso!', 'data' => $return], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar no banco de dados!'], 400);
        }
    }
    public function alterarSituacaoLancamento()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token);
        $id = parent::get_payload_field('id', $token);
        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2) {
            $return = $this->associados_model->alterarSituacaoLancamento($this->post('id'), $this->post('situacao'));
            if (sizeof($return) > 0) {
                return parent::set_response(['status'  => true, 'message' => 'Situacao alterada com sucesso!'], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao inserir no banco de dados!'], 400);
        }
    }
    public function buscarConveniosFixos()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2 || $permissao_tipo == 1) {
            $payload = JWT::decode($this->post('id_associado'), $this->config->item('jwt_key'));
            $id = $payload->id;
            $return = $this->associados_model->buscarConveniosFixos($id);

            if (sizeof($return) > 0) {
                return parent::set_response(['status'  => true, 'message' => 'Busca realizada com sucesso!', 'data' => $return], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar no banco de dados!'], 400);
        }
    }
    public function buscarTodosConvFixos()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2 || $permissao_tipo == 1) {
            $payload = JWT::decode($this->post('id_associado'), $this->config->item('jwt_key'));
            $id = $payload->id;
            $return = $this->associados_model->buscarTodosConvFixos();

            if (sizeof($return) > 0) {
                return parent::set_response(['status'  => true, 'message' => 'Busca realizada com sucesso!', 'data' => $return], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao buscar no banco de dados!'], 400);
        }
    }
    public function inserirConvFixo()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token); //verifica o token enviado através do header
        $id = parent::get_payload_field('id', $token);

        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2) {
            $payload = JWT::decode($this->post('id_associado'), $this->config->item('jwt_key'));
            $id = $payload->id;

            $return = $this->associados_model->inserirConvFixo($id, $this->post('id_convenio'), $this->post('data'));
            if ($this->post('conf') == 1) {
            }
            if (sizeof($return) > 0) {
                return parent::set_response(['status'  => true, 'message' => 'Dados inseridos com sucesso!'], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao inserir no banco de dados!'], 400);
        }
    }
    public function alterarSituacaoConvFixo()
    {
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token);
        $id = parent::get_payload_field('id', $token);
        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2) {
            $return = $this->associados_model->alterarSituacaoConvFixo($this->post('id_associado_convenio'), $this->post('id_situacao'));
            if (sizeof($return) > 0) {
                return parent::set_response(['status'  => true, 'message' => 'Situacao alterada com sucesso!'], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao inserir no banco de dados!'], 400);
        }
    }
    public function inserirLancamento(){
        $token = parent::get_header_value($this->tk);
        parent::verificar_token($token);
        $id = parent::get_payload_field('id', $token);
        $permissao = $this->associados_model->get_permissao($id, 4);
        $permissao_nivel = $permissao[0]->nivel;
        $permissao_tipo = $permissao[0]->id_permissao_tipo;
        if ($permissao_nivel == 0 || $permissao_tipo == 2) {
            $payload = JWT::decode($this->post('socio'), $this->config->item('jwt_key'));
            $id = $payload->id;
            $lanc = array(
                'ano' => $this->post('tAno'),
                'mes' => $this->post('tMes'),
                'id_associado' => $id,
                'id_convenio' => $this->post('tConvenios'),
                'valor' => $this->post('tValor')
            );
            $return = $this->associados_model->inserirLancamento($lanc);
            if ($return == true) {
                return parent::set_response(['status'  => true, 'message' => 'Lançamento inserido com sucesso!'], 200);
            }
            return parent::set_response(['status'  => false, 'message' => 'Erro ao inserir no banco de dados!'], 400);
        }
    }
}
