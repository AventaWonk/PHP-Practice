<?php
	include 'response.php'; 

	/**
	* Router class
	*/
  class Router
	{
		private static function getFunctionArgs($class, $method) {
			$args = [];
			if(method_exists($class, $method)) {
				$ReflectionMethod =  new ReflectionMethod($class, $method);
				foreach( $ReflectionMethod->getParameters() as $param) {
		      $args[] = $param->name;
		    }
			} else {
				throw new Exception("Error: Processing Request", 1);
			}
			return $args;
		}

		private static function getRecivedParams($arguments) {
			$params = [];
			foreach ($arguments as $value) {
				if(!isset($_GET[$value])){
					throw new Exception("Error: hasnt all params", 1);
				}
				$params[] = $_GET[$value];
			}
			return $params;
		}

		public static function start() {
			try {
		//     $method = $_SERVER['REQUEST_METHOD'];
    //     switch ($method) {
    //     	case 'GET':
        		
    //     		break;
    //     	case 'POST':
        		
    //     		break;
    //     	default:
    //     			throw new Exception("Unexpected Header");
    //     		break;
    //     }

				$pieces = explode('.', $_GET['method']);

				$className = mb_convert_case($pieces[0], MB_CASE_TITLE) . "Controller";
				$methodName = $pieces[1];
				$fileName = "Controllers/" . $pieces[0] . "-controller.php";

				include($fileName);
				$arguments = self::getFunctionArgs($className, $methodName);
				$params = self::getRecivedParams($arguments);
				
				$controller = new $className();
				$result = $controller->$methodName(...$params);
			
				Response::send($result);

			} catch (Exception $e) {
			  Response::send($e);
			}
		}
	}
