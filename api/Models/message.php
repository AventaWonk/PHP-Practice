<?php

	/**
	* Message model
	*/
	class Message
	{
		public $id;
		public $text;

		function __construct($text = "") {
	    	$this->id = uniqid("", true); 
	    	$this->text = $text;
		}
	}
	