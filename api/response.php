<?php

	/**
	* 
	*/
	class ReponseBody
	{
		public $code;
		public $text;
		
		function __construct($code, $text)
		{
			$this->code = $code;
			$this->text = $text;
		}
	}

	/**
	* 
	*/
	class Response
	{
		public static function success() {
			return new ReponseBody("1", "Success");
		}

		public static function failed() {
			return new ReponseBody("0", "Failed");
		}

	}