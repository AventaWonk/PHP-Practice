<?php
	include './library/controller.php';
	include './Models/message.php';

	/**
	* Message controller
	*/
	class MessageController extends Controller
	{
		public function add($text) {
			$message = new Message($text);
			try {  
				$dbh = new PDO('mysql:host=localhost;dbname=api_test', 'root'); // will be moved
				$sth = $dbh->prepare("INSERT INTO messages (id, text) values (:id, :text)");  
				$sth->execute((array) $message);
			} catch (Exception $e) {
				 
			}
			
		}

		public function get(){
			$messages = [];
			try {  
				$dbh = new PDO('mysql:host=localhost;dbname=api_test', 'root'); // will be moved
				$sth = $dbh->query('SELECT id, text from messages');  
				$sth->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Message');  
				while($obj = $sth->fetch()) {  
				    $messages[] = $obj;  
				}
			} catch (Exception $e) {
				
			}
			return $messages;
		}
	}
