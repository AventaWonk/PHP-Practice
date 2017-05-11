<?php
	include './Models/message.php';
	include './response.php';

	/**
	* Message controller
	*/
	class MessageController
	{
		function add($text) {
			$message = new Message($text);
			try {  
				$dbh = new PDO('mysql:host=localhost;dbname=api_test', 'root'); // will be moved
				// $dbh->beginTransaction();
				// $dbh->exec("insert into messages (id, text) values ('".$message->id."', '".$message->text."')");
				// $dbh->commit();
				$sth = $dbh->prepare("INSERT INTO messages (id, text) values (:id, :text)");  
				$sth->execute((array)$message);
			} catch (Exception $e) {
				return Response::failed(); 
			}
			return Response::success(); 
		}

		function get(){
			$messages = [];
			try {  
				$dbh = new PDO('mysql:host=localhost;dbname=api_test', 'root'); // will be moved
				$sth = $dbh->query('SELECT id, text from messages');  
				$sth->setFetchMode(PDO::FETCH_CLASS, 'Message');  
				while($obj = $sth->fetch()) {  
				    $messages[] = $obj;  
				}
			} catch (Exception $e) {
				return Response::failed(); 
			}
			return $messages;
		}
	}
