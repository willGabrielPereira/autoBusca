<?php
	header('Content-Type: text/html; charset=UTF-8');
	date_default_timezone_set('America/Sao_Paulo');
	
	// Banco de Dados para configuração
	$url = "127.0.0.1";     // IP do host
	$dbname="autobd";          // Nome do database
	$usuario="root";        // Usuário do database
	$password="";           // Senha do database
	
	// Tabelas do Banco de Dados
	$tb_usuario = "usuario";
	$tb_veiculo = "veiculo";
	$tb_marca = "marca";
	$tb_cidade = "cidade";
	$tb_estado = "estado";
?>
