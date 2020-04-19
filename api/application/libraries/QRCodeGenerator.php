<?php 
	require_once APPPATH.'libraries/phpqrcode/qrlib.php';

	class QRCodeGenerator extends QRcode{

		public function __construct(){
		}

		public function gerar_qrcode_base64($valor){
			return base64_encode(parent::png($valor));
		}
	}
?>