<?php
	include './library/model.php';
	
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
	