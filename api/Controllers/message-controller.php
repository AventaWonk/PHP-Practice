<?php
namespace app;

include './lib/controller.php';
include './Models/message.php';

use general\Controller;
use general\Response;

	/**
	* Message controller
	*/
	class MessageController extends Controller
	{
		public function add($text) {
			$message = new Message($text);
			Message::add($message);	
		}

		public function get() {
			$messages = Message::findAll();
			return $this->JSON($messages);
		}

		public function changeText($id, $newText) {
			$message = new Message();
			$message->text = null;
			$message->id = $id;
			$message = Message::find($message);
			$message->text = $newText;
			$message->save();
		}

		public function delete($id) {
			$message = new Message();				
			$message->id = $id;
			$message->text = null;
			$message = Message::find($message);
			$message->delete();
		}
	}
