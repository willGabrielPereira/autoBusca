<?php 
	session_start();
 ?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
 	<meta charset="UTF-8">
 	<link rel="stylesheet" href="css/css.css">
	<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
    <title>Sistema de Vendas</title>
    <style>
        body{
            background-image: url('img/sobre.jpg');
        }
    </style>
</head>
<body>
	<?php 
	if (isset($_SESSION['logado']) && $_SESSION['logado'] == "TRUE"){
		include 'menu_loged.php';	
	}else{
		include 'menu.php';
	} ?>
	<br>
	<center><h1 class="titulo">Desenvolvedores</h1></center><br><br>
	<div class="gatoes">
		<img src="img/bruno.jpeg">
		<div class="descricao">
			<h2>Bruno Gilz</h2>
			<h3>Técnico em informática</h3>
			<h3>IFC - Rio do Sul U.U.</h3>
			<h3>gilzgnr001@gmail.com</h3>
			<h3>Designer</h3>
		</div>
	</div>
	<div class="gatoes">
		<img src="img/william.jpg">
		<div class="descricao">
			<h2>William Gabriel</h2>
			<h3>Técnico em informática</h3>
			<h3>IFC - Rio do Sul U.U.</h3>
			<h3>will.gabriel.pereira@gmail.com</h3>
			<h3>Programador</h3>
		</div>
	</div>
</body>
</html>