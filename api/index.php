<?php
	include 'router.php';	

	if(isset($_GET['method'])) {
		Router::start();
	} else {
		echo "Failed";
	}
