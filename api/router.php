<?php

	/**
	* Router class
	*/
	class Router
	{
		public static function start() {
			try {

				$pieces = explode('.', $_GET['method']);
				$class_name = $pieces[0];
				$method_name = $pieces[1];
				$param = "text";

				include("Controllers/" . $class_name . "-controller.php");
				$class_name = mb_convert_case($class_name, MB_CASE_TITLE);
				$class_name = $class_name . "Controller";
				$controller = new $class_name();
				$result = $controller->$method_name($param);

				header("Access-Control-Allow-Orgin: *");
			    header("Access-Control-Allow-Methods: *");
			    header("Content-Type: application/json");
				echo json_encode($result);

			} catch (Exception $e) {
			    echo $e->getMessage();
			}
			
		}
	}
