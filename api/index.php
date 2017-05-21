<?php
  include 'library/router.php';	
// $time_start = microtime(true);

  if(isset($_GET['method'])) {
    Router::start();
  } else {
    echo "Failed";
  }

// $time_end = microtime(true);
// echo ($time_end - $time_start);