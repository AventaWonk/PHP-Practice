<?php
	include 'library/router.php';	

	if(isset($_GET['method'])) {
		Router::start();
	} else {
		echo "Failed";
	}
