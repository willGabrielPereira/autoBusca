<?php
	header('Content-Type: text/html; charset=UTF-8');
	if (!file_exists('conf/conf.inc.php')) {
		include '../conf/conf.inc.php';
	}else{
		include 'conf/conf.inc.php';
	}
	$conexao = mysqli_connect($url,$usuario,$password,$dbname);
	if (mysqli_connect_errno())
		echo mysqli_connect_error();
	mysqli_set_charset($conexao, 'utf8');
?>