<?php
	include 'response.php'; 

	/**
	* Router class
	*/
  class Router
	{	
	  const GET = "GET";
		const POST = "POST";

		public static function start() {
			try {  
				$params = [];
				$method;
				$class_name;
				$method_name;
				$file_name;
				$args = [];

				$method = $_SERVER['REQUEST_METHOD'];
				if($method == self::GET) {
					$pieces = explode('.', $_GET['method']);
				} else {
					$pieces = explode('.', $_POST['method']);
				}
				$class_name = mb_convert_case($pieces[0], MB_CASE_TITLE) . "Controller";
				$method_name = $pieces[1];
				$file_name = "Controllers/" . $pieces[0] . "-controller.php";

				if (file_exists($file_name)) {
					include($file_name);
				} else {
					throw new Exception("Hasnt method", 1);
				}
				
				if(method_exists($class_name, $method_name)) {
					$ReflectionMethod =  new ReflectionMethod($class_name, $method_name);
					foreach( $ReflectionMethod->getParameters() as $param) {
			      $args[] = $param->name;
			    }
				} else {
					throw new Exception("Error: Processing Request", 1);
				}

				if($method == self::GET) {
					foreach ($args as $value) {
						if(!isset($_GET[$value])){
							throw new Exception("Error: hasnt all params", 1);
						}
						$params[] = $_GET[$value];
					}
				} else {
					foreach ($args as $value) {
						if(!isset($_POST[$value])){
							throw new Exception("Error: hasnt all params", 1);
						}
						$params[] = $_POST[$value];
					}
				}
				
				$controller = new $class_name();
				$result = $controller->$method_name(...$params);
				Response::send($result);

			} catch (Exception $e) {
			  Response::send($e);
			}
		}
	}
