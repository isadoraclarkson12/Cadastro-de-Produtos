<?php
	header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");

	if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction'){ 

		$email = 'jonathawss@gmail.com'; 
		$token = '68EA9DC98791435CB5D6A1EB98133244';

		$url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/'.$_POST['notificationCode'].'?email='.$email.'&token='.$token;

		$curl = curl_init($url); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 		
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($curl, CURLOPT_URL, $url); 
		$transaction = curl_exec($curl); 
		curl_close($curl);

		if($transaction == 'Unauthorized'){ 
			//$transaction="erro"; 
			exit;//Mantenha essa linha 
		}else{ 
			$transaction = simplexml_load_string($transaction); 
			$status = $transaction->status; 
			$id     = $transaction->reference;
			$data   = date('Y-m-d H-i:s');
		} 
		//mysql_query("UPDATE usuario SET status='$status' WHERE id='$id' ");
		$name = 'arquivo.txt';
		$text = var_export($transaction, true);
		$file = fopen($name, 'a');
		fwrite($file, $text);
		fclose($file);
	}	

?>
