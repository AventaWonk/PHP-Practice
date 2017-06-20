<?php
namespace app;

include './lib/controller.php';
include './lib/authentication.php';

use general\Controller;
use authentication\Authentication;
use authentication\User;

	/**
	* Message controller
	*/
	class UserController extends Controller
	{
		public function add($login, $password) {
			try {
				$auth = new Authentication();
				$user = new User();
				$user->login = $login;
				$user->password = $password;
				$user->firstName = "22";
				$user->lastName = "33";
				echo $auth->addUser($user);
			} catch (Exception $e) {
				return $e; 
			}		
		}

		public function get() {
			try {  
				$users = User::findAll();
			} catch (Exception $e) {
				return $e;
			}
			return $users;
		}
	}


