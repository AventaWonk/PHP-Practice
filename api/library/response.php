<?php

	/**
	* 
	*/
	class ResponseWrapper
	{
		public $response;
		
		function __construct($object)
		{
			$this->response = $object;
		}
	}

	/**
	* 
	*/
	class ResponseSuccess
	{
		public $code;
		public $body;

		function __construct($body, $code = 1) {
			$this->body = $body;
			$this->code = $code;
		}

		public function get() {
			if($this->body) {
				return new ResponseWrapper($this->body);
			}
			return new ResponseWrapper($this->code);
		}
	}

	/**
	* 
	*/
	class ReponseError
	{
		
	}

	/**
	* 
	*/
	class Response
	{
		private static function success() {
					
		}

		private static function failed() {
			
		}

		public static function send($object) {
			header("Access-Control-Allow-Orgin: *");
			header("Access-Control-Allow-Methods: *");
			header("Content-Type: application/json");

			$response = new ResponseSuccess($object);
			echo json_encode( $response->get() );
		}
	}
	