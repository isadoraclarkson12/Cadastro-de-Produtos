<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Notification{
		
		private $app_id;
		private $rest_api_id;

		private $player_ids;

		private $titulo;
		private $texto;

		function __construct(){
			$this->app_id      = "97e305f5-15a0-47b7-b2d5-e921917d2a5f";
			$this->rest_api_id = "NTllMDdhNGUtYjI5Mi00ZDZhLTg3MjUtMzAzMTZjYjk4YjA4";
			$this->player_ids  = array();
		}

		public function sendMessage(){
			$content = array(
				"en" => 'English Message'
				);
			
			$fields = array(
				'app_id' => $this->app_id,
				'included_segments' => array('Active Users'),
				//'data' => array("foo" => "bar"),
				'data'     => null,
				'contents' => $content
			);
			
			$fields = json_encode($fields);
			/*$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
													   'Authorization: '.$this->rest_api_id));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			$response = curl_exec($ch);
			curl_close($ch);*/
			$return["allresponses"] = $this->curlNotification($fields);
			$return = json_encode($return);
			return $return;
		}

		public function sendMessageFilters(){
			$content = array(
				"en" => 'English Message'
				);
			
			$fields = array(
				'app_id'  => $this->app_id,
				'filters' => array(array("field" => "tag", 
					                     "key"   => "level", 
					                     "relation" => "=", 
					                     "value" => "10"),
										 array("operator" => "OR"),
										 array("field"    => "amount_spent", 
										 	   "relation" => "=", 
										 	   "value"    => "0")),
				//'data' => array("foo" => "bar"),
				'contents' => $content
			);
			
			$fields = json_encode($fields);
	    	print("\nJSON sent:\n");
	    	print($fields);
			/*$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
													   'Authorization: '.$this->rest_api_id));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			$response = curl_exec($ch);
			curl_close($ch);*/
			$return["allresponses"] = $this->curlNotification($fields);
			$return = json_encode($return);

			return $return;
		}

		public function sendMessagePlayerIDs(){
			$content = array(
				"en" => 'English Message'
				);
			
			$fields = array(
				'app_id' => $this->app_id,
				'include_player_ids' => $this->player_ids,
				//'data' => array("foo" => "bar"),
				'contents' => $content
			);
			
			$fields = json_encode($fields);
			/*$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
													   'Authorization: '.$this->rest_api_id));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			$response = curl_exec($ch);
			curl_close($ch);*/
			$return["allresponses"] = $this->curlNotification($fields);
			$return = json_encode($return);

			return $return;
		}

		public function curlNotification($fields){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
													   'Authorization: '.$this->rest_api_id));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			$response = curl_exec($ch);
			curl_close($ch);
			return $response;
		}
	}
?>