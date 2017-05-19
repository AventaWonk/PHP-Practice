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
				Message::add(new Message($text));
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
				$message->text = null;
				$message->id = $id;

				$message = Message::find($message);
				$message->delete();
			} catch (Exception $e) {
				return $e;
			}
		}
	}
