<?php
require_once '../library/config.php';
	//$_SESSION['emp_id'] = $emp_id;
	//$_SESSION['emp_name'] = $emp_name;	
	session_unset();
	session_destroy();

	header('Location: ../login');
?>