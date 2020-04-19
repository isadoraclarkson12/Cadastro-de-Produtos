<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Validation extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function validate($fields, $method = ''){
		/* ---------- VALIDACOES CLIENTE ---------- */
		if($method == 'cadastro_cliente'){
			return $this->validate_cadastro_cliente($fields);
		}
		if($method == 'login'){
			return $this->validate_login($fields);
		}
		if($method == 'alterar_senha_cliente'){
			return $this->validate_alterar_senha_cliente($fields);
		}
		if($method == 'verifica_cod_cadastro_cliente'){
			return $this->validate_verifica_cod_cadastro_cliente($fields);
		}
		if($method == 'gerar_recovery_token'){
			return $this->validate_gerar_recovery_token($fields);
		}
		if($method == 'verifica_token_redefinicao'){
			return $this->validate_verifica_token_redefinicao($fields);
		}
		// if($method == 'altera_senha'){
		// 	return $this->validate_altera_senha($fields);
		// }
		if($method == 'altera_dados_cobranca'){
			return $this->validate_altera_dados_cobranca($fields);
		}
		if($method == 'comprar'){
			return $this->validate_comprar($fields);
		}
		// if($method == 'altera_senha_perfil'){
		// 	return $this->validate_altera_senha_perfil($fields);
		// }
		if ($method == 'alterarSenha'){
			return $this->validate_alterarSenha($fields);
		}
		if ($method == 'redefinirSenha'){
			return $this->validate_redefinirSenha($fields);
		}
	}

	public function validate_cadastro_cliente($fields){
		$status = true;
		$message = '';
		if(strlen(trim($fields['nickname'])) < 5 || 
		   strlen(trim($fields['nickname'])) > 15){
			$status = false;
		    $message .= "Informe um nickname de 5 a 15 caracteres.\n";
		}
		if(strlen(trim($fields['telefone'])) != 11){
			$status = false;
			$message .= "Informe um telefone valido (11 caracteres).\n";
		}
		if(strlen(trim($fields['senha'])) < 8 || 
           strlen(trim($fields['senha'])) > 16){
			$status = false;
			$message .= "Senha deve ter de 8 a 16 caracteres.\n";
		}
		if(strlen(trim($fields['confirmar_senha'])) < 8 || 
           strlen(trim($fields['confirmar_senha'])) > 16){
			$status = false;
			$message .= "Confirmaçao de senha deve ter de 8 a 16 caracteres.\n";
		}
		if($this->valida_telefone(trim($fields['telefone'])) != 'tel'){
			$status = false;
			$message .= "Telefone deve conter apenas numeros.\n";
		}
		if(trim($fields['email']) == ''){
			$status = false;
			$message .= "Informe um e-mail valido.\n";
		}
		if(!$this->validaEmail(trim($fields['email']))){
			$status = false;
			$message .= "Informe um e-mail valido.\n";
		}
		return array('status' => $status, 'message' => $message);
	}

	public function validate_login($fields){
		$status = true;
		$message = '';
		if(trim($fields['autenticacao']) == ''){
			$status = false;
			$message .= "Forneca dados validos de login.\n";
		}
		if(strlen(trim($fields['senha'])) < 8 || 
           strlen(trim($fields['senha'])) > 16){
			$status = false;
			$message .= "Senha deve ter de 8 a 16 caracteres.\n";
		}
		return array('status' => $status, 'message' => $message);
	}



	public function validate_alterar_senha_cliente($fields){

	}

	public function validate_avaliar_profissional($fields){

	}

	public function validate_autenticar_conta($fields){

	}

	public function validate_gerar_recovery_token($fields){
		$status = true;
		$message = '';		
	  	if($this->verifica_tipo_autenticacao($fields['autenticacao']) == 'tel'){
	  		if(trim($fields['autenticacao']) == ''){
				$status = false;
				$message .= "Forneca um telefone valido.\n";
	  		}else{
	  			if(strlen(trim($fields['autenticacao'])) != 11){
					$status = false;
					$message .= "Informe um telefone valido (11 caracteres).\n";
				}
	  			/*if($this->valida_telefone(trim($fields['autenticacao'])) != 'tel'){
	  				$status = false;	
	  				$message .= "Telefone deve conter apenas numeros.\n";
	  			}*/
	  		}
	  	}else{
	  		if(!$this->validaEmail($fields['autenticacao'])){
				$status = false;
				$message .= "Informe um e-mail valido.\n";
	  		}
	  	}
		return array('status' => $status, 'message' => $message);	  	
	}

	public function validate_verifica_token_redefinicao($fields){
		$status = true;
		$message = '';		
	  	if($this->verifica_tipo_autenticacao($fields['autenticacao']) == 'tel'){
	  		if(trim($fields['autenticacao']) == ''){
				$status = false;
				$message .= "Forneca um telefone valido.\n";
	  		}else{
			  	if(strlen(trim($fields['autenticacao'])) != 11){
					$status = false;
					$message .= "Informe um telefone valido (11 caracteres).\n";
				}
	  			/* if($this->valida_telefone(trim($fields['autenticacao'])) != 'tel'){
	  				$status = false;	
	  				$message .= "Telefone deve conter apenas numeros.\n";
	  			} */
	  		}
	  	}else{
	  		if(!$this->validaEmail($fields['autenticacao'])){
				$status = false;
				$message .= "Informe um e-mail valido.\n";
	  		}
	  	}
	  	if(strlen($fields['recovery_token']) != 6){
			$status = false;
			$message .= "Informe token valido de 6 digitos.\n";
	  	}
		return array('status' => $status, 'message' => $message);
	}

	// public function validate_altera_senha($fields){

	// 	$status = true;
	// 	$message = '';
	//   	if($this->verifica_tipo_autenticacao($fields['autenticacao']) == 'tel'){
	//   		if(trim($fields['autenticacao']) == ''){
	// 			$status = false;
	// 			$message .= "Forneca um telefone valido.\n";
	//   		}else{
	//   			if(strlen(trim($fields['autenticacao'])) != 11){
	// 				$status = false;
	// 				$message .= "Informe um telefone valido (11 caracteres).\n";
	// 			}
	//   			// if($this->valida_telefone(trim($fields['autenticacao'])) != 'tel'){
	//   			// 	$status = false;
	//   			// 	$message .= "Telefone deve conter apenas numeros.\n";
	//   			// }
	//   		}
	//   	}else{
	//   		if(!$this->validaEmail($fields['autenticacao'])){
	// 			$status = false;
	// 			$message .= "Informe um e-mail valido.\n";
	//   		}
	//   	}
	//   	if(strlen($fields['recovery_token']) != 6){
	// 		$status = false;
	// 		$message .= "Informe token valido de 6 digitos.\n";
	//   	}

	//   	if(strlen(trim($fields['nova_senha'])) < 8 || 
 //           strlen(trim($fields['nova_senha'])) > 16){
	// 		$status = false;
	// 		$message .= "Senha deve ter de 8 a 16 caracteres.\n";
	// 	}
	// 	if(strlen(trim($fields['confirma_nova_senha'])) < 8 || 
 //           strlen(trim($fields['confirma_nova_senha'])) > 16){
	// 		$status = false;
	// 		$message .= "Confirmaçao de senha deve ter de 8 a 16 caracteres.\n";
	// 	}
	// 	if(trim($fields['nova_senha']) != 
	// 	   trim($fields['confirma_nova_senha'])){
	// 		$status = false;
	// 		$message .= "As senhas nao combinam.\n";
	// 	}
	// 	return array('status' => $status, 'message' => $message);
	// }

	public function validate_altera_dados_cobranca($fields){
		$status = true;
		$message = '';
		if(trim($fields['usuario']) == '' || trim($fields['usuario']) == '0'){
			$status = false;
			$message .= "Informe seu id.\n";
		}

		if(strlen(trim($fields['nome_cartao'])) < 4){
			$status = false;
			$message .= "Informe o nome impresso no cartao válido.\n";
		}

		if(strlen(trim($fields['num_cartao'])) != 16){
			$status = false;
			$message .= "Numero do cartao deve conter 16 digitos.\n";
		}

		if($this->valida_num($fields['num_cartao']) != 'num'){
			$status = false;
			$message .= "Numero do cartao deve conter apenas numeros.\n";
		}
		return array('status' => $status, 'message' => $message);
	}

	public function validate_comprar($fields){
		$status = true;
		$message = '';
		if(strlen(trim($fields['cvv_cartao'])) != 3){
			$status = false;
			$message .= "Digite um cvv valido.\n";
		}
		if($this->valida_num($fields['cvv_cartao']) != 'num'){
			$status = false;
			$message .= "CVV do cartao deve conter apenas numeros.\n";
		}
		if($this->valida_num($fields['pacote']) != 'num'){
			$status = false;
			$message .= "Pacote invalido.\n";
		}
		if(trim($fields['pacote']) == '' || $fields['pacote'] <= 0){
			$status = false;
			$message .= "Pacote invalido.\n";
		}
		if($this->valida_num($fields['usuario']) != 'num'){
			$status = false;
			$message .= "Usuario invalido.\n";
		}
		if(trim($fields['usuario']) == '' || $fields['usuario'] <= 0){
			$status = false;
			$message .= "Usuario invalido.\n";
		}

		if(trim($fields['tipo_usuario']) != 'clientes' && 
		   trim($fields['tipo_usuario']) != 'profissionais'){
			$status = false;
			$message .= "Informe o tipo de usuario.\n";
		}

		if(strlen(trim($fields['validade_cartao'])) != 7){
			$status = false;
			$message .= "Verifique o vencimento do seu cartao.\n";
		}else{
			$data_parts = explode("-", $fields['validade_cartao']);
			if($data_parts[0] < date('Y')){
				$status = false;
				$message .= "O cartao se encontra vencido.\n";
			}else{
				if($data_parts[1] < date('m')){
					$status = false;
					$message .= "O cartao se encontra vencido.\n";
				}
			}
		}
		return array('status' => $status, 'message' => $message);
	}

	// public function validate_altera_senha_perfil($fields){

	// 	$status = true;
	// 	$message = '';

	//     if(trim($fields['senha_atual']) == trim($fields['nova_senha'])){
	//      	$status = false;
	// 		$message .= "Voce ja esta utilizando esta senha.\n";
	//     }

	//     if(trim($fields['nova_senha']) != trim($fields['confirma_nova_senha'])){
	//      	$status = false;
	// 		$message .= "As senha nao conbinam.\n";
	//     }

	//     if(trim($fields['senha_atual']) == ''){
	//      	$status = false;
	// 		$message .= "Informe sua senha atual.\n";
	//     }

	//     if(trim($fields['nova_senha']) == ''){
	//      	$status = false;
	// 		$message .= "Informe sua nova senha.\n";
	//     }

	//     if(trim($fields['confirma_nova_senha']) == ''){
	//      	$status = false;
	// 		$message .= "Informe a confirmação de senha.\n";
	//     }
	// 	if(strlen(trim($fields['nova_senha'])) < 8 || 
 //           strlen(trim($fields['nova_senha'])) > 16){
	// 		$status = false;
	// 		$message .= "Senha deve ter de 8 a 16 caracteres.\n";
	// 	}
	//     if(strlen(trim($fields['confirma_nova_senha'])) < 8 || 
 //           strlen(trim($fields['confirma_nova_senha'])) > 16){
	// 		$status = false;
	// 		$message .= "Senha deve ter de 8 a 16 caracteres.\n";
	// 	}
	// 	return array('status' => $status, 'message' => $message);
	// }



	public function validate_alterarSenha($fields)
	{
		$status = true;
	 	$message = '';

        if ($fields['email'] == "")
        {
        	$status = false;
            $message .= "Informe um e-mail válido.<br />";
        }
        else
        {
            if($fields['emailToken'] != $fields['email'])
            {
            	$status = false;
                $message .= "O e-mail informado não pertence a sua conta.<br />";
            }
        }

        if ($fields['novaSenha'] == "")
        {
        	$status = false;
            $message .= "Informe sua nova senha.<br />";
        }
        else
        {
            if (strlen($fields['novaSenha']) < 8)
            {
            	$status = false;
                $message .= "A senha deve ter no mínimo 8 caracteres.<br />";
            }
        }

        if ($fields['confirmarNovaSenha'] == "")
        {
        	$status = false;
            $message .= "Confirme sua nova senha.<br />";
        }
        else
        {
            if (strlen($fields['confirmarNovaSenha']) < 8)
            {
            	$status = false;
                $message .= "A confirmação da senha deve ter no mínimo 8 caracteres.<br />";
            }
        }

        if (($fields['novaSenha'] != "" && $fields['confirmarNovaSenha'] != "") &&
        	 $fields['novaSenha'] != $fields['confirmarNovaSenha'] )
        {
        	$status = false;
            $message .= "As senhas não coincidem.<br />";
        }
        return array('status' => $status, 'message' => $message);
	}

	public function validate_redefinirSenha($fields)
	{
		$status = true;
	 	$message = '';

        if ($fields['senha'] == "")
        {
        	$status = false;
            $message .= "Informe sua nova senha.<br />";
        }
        else
        {
            if (strlen(trim($fields['senha'])) < 8 || strlen(trim($fields['senha'])) > 16)
            {
            	$status = false;
                $message .= "A senha deve ter entre 8 e 16 caracteres.<br />";
            }
        }
        if ($fields['confirmarSenha'] == "")
        {
        	$status = false;
            $message .= "Confirme sua nova senha.<br />";
        }
        else
        {
            if (strlen(trim($fields['confirmarSenha'])) < 8 || strlen(trim($fields['confirmarSenha'])) > 16 )
            {
            	$status = false;
                $message .= "A confirmação da senha deve ter entre 8 e 16 caracteres.<br />";
            }
        }

        if ((trim($fields['senha']) != "" && trim($fields['confirmarSenha']) != "") &&
        	 trim($fields['senha']) != trim($fields['confirmarSenha']) )
        {
        	$status = false;
            $message .= "As senhas não coincidem.<br />";
        }

        if (trim($fields['recoveryToken']) == '')
        {
        	$status = false;
            $message .= "Não foi informado um token válido.<br />";
        }
        return array('status' => $status, 'message' => $message);
	}

    public function verifica_tipo_autenticacao($autenticacao){
        $qtdNums = 0;
        $tipo    = '';
        for($i=0;$i<strlen($autenticacao);$i++){ 
           $aux = substr($autenticacao, $i, 1);
           if(ord($aux) >= 48 && ord($aux) <= 57){
              $qtdNums++;
           }
        }
        if($qtdNums == strlen($autenticacao)){
            $tipo = 'tel';
        }else{
            $tipo = 'email';
        }
        return $tipo;
    }

    public function valida_num($num){
        $qtdNums = 0;
        $tipo    = '';
        for($i=0;$i<strlen($num);$i++){ 
           $aux = substr($num, $i, 1);
           if(ord($aux) >= 48 && ord($aux) <= 57){
              $qtdNums++;
           }
        }
        if($qtdNums == strlen($num)){
            $tipo = 'num';
        }else{
            $tipo = 'nnum';
        }
        return $tipo;
    }

    public function valida_telefone($telefone){
        $qtdNums = 0;
        $tipo    = '';
        for($i=0;$i<strlen($telefone);$i++){ 
           $aux = substr($telefone, $i, 1);
           if(ord($aux) >= 48 && ord($aux) <= 57){
              $qtdNums++;
           }
        }
        if($qtdNums == strlen($telefone)){
            $tipo = 'tel';
        }else{
            $tipo = 'ntel';
        }
        return $tipo;
    }

	public function validaEmail($email){
	    $er = "/^(([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}){0,1}$/";
	    if(preg_match($er, $email)){
			return true;
	    }else{
			return false;
	    }
	}
}