<?php
	session_start();
	
	if (isset($_SESSION['logado']) && $_SESSION['logado'] == "TRUE") {
			echo "<script>
	    			alert('Você já está logado');
	    		</script>";

			header('location:loged.php');
	}
?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
 	<meta charset="UTF-8">
    <title>AutoBusca</title>
</head>
<body>
	<?php //include 'menu.php';?>
	<h1>AutoBusca</h1>
	<div>
		<p><a href="login.php">Fazer login</a></p>
		<p><a href="list_veiculo.php">Procurar veículos</a></p>
	</div>
</body>
</html>
