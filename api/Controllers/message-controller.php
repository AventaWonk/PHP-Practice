<?php
	include './library/controller.php';
	include './Models/message.php';

	/**
	* Message controller
	*/
	class MessageController extends Controller
	{
		public function add($text) {
			try {  
				$message = new Message($text);
				Message::add($message);
			} catch (Exception $e) {
				return $e; 
			}		
		}

		public function get() {
			try {  
				$messages = Message::findAll();
			} catch (Exception $e) {
				return $e;
			}
			return $messages;
		}

		public function changeText($id, $newText) {
			try {  
				$message = new Message();
				$message->text = null;
				$message->id = $id;

				$message = Message::find($message);
				$message->text = $newText;
				$message->save();
			} catch (Exception $e) {
				return $e;
			}
		}

		public function delete($id) {
			try {
				$message = new Message();
				$message2 = new Message();
				$message->text = null;
				$message->id ="591608940d2791.33594588";
				$message2->text = null;
				$message2->id = "5919a0333ca557.93892933";

				$message = Message::find($message);
				$message2 = Message::find($message2);
				$message->text = "DOMDOMDOM";
				$message->save();
				// $message->delete();
			} catch (Exception $e) {
				return $e;
			}
		}
	}
