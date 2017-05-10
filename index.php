<?php
	namespace API
	{	
		/**
		* Router class for a RESTful API
		*/
		class Router
		{
			public function callAction($action, ...$params) {

			}
		}

		/**
		* Just a message class
		*/
		class Message
		{
			public $id;
			public $text;

			function __construct($text) {
		    	$this->id = uniqid("", true); // 
		    	$this->text = $text;
			}
		}

		/**
		* Actions class for a RESTful API (that's no good, don't do this in production)
		*/
		class Actions
		{	
			private $messages = [];

			public function addMessage($text) {
				$this->messages[] = new Message($text);
			}
			public function getMessages() {
				return $this->messages;
			}
		}
	}

	namespace Index
	{	
		use API\Actions;

		$actions = new Actions();
		$result = $actions->addMessage("The message has been added successfully");
		$result = $actions->addMessage("The message has been added successfull v2");
		$result = $actions->getMessages();
		echo json_encode($result);
	}
