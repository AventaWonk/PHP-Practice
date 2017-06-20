<?php
namespace app;

include './lib/model.php';
use general\Model;

	/**
	* Message model
	*/
	class Message extends Model
	{
		public $id;
		public $text;

		function __construct($text = "") {
			$this->id = uniqid("", true); 
			$this->text = $text;
		}
	}
