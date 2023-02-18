<?php
ob_start();
$action = $_GET['action'];

include 'admin_class.php';
$crud = new Action();

if($action == "save_course"){
	$save = $crud->save_course();
	if($save)
		echo $save;
}

ob_end_flush();
?>


