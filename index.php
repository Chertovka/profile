<?php
	/**
	* Главный файл
	*/

	session_start();

	header('Content-Type: text/html; charset=UTF8');
	error_reporting(E_ALL);

	ob_start();

	$mode = isset($_GET['mode'])  ? $_GET['mode'] : false;
	$user = isset($_SESSION['user']) ? $_SESSION['user'] : false;
	$err = array();

	include './config.php';
	include './bd/bd.php';
	include './func/funct.php';

	switch($mode)
	{
		case 'reg':
			include './scripts/reg/reg.php';
			include './scripts/reg/reg_form.html';
		break;
		
		case 'auth':
			include './scripts/auth/auth.php';
			include './scripts/auth/auth_form.php';
		break;

		case 'lk':
			include './scripts/lk/lk.php';
		break;
	}
    
	$content = ob_get_contents();
	ob_end_clean();

	include './html/index.php';
?>			