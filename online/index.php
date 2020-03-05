<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>AutoBusca</title>
	<style>
        body{
            background-image: url('img/pesquisaonline.jpg');
        }
    </style>
</head>
<body>
	<link rel="stylesheet" type="text/css" href="../css/css.css">
	<link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
<?php
	if (isset($SESSION['logado']) && $SESSION['logado'] == TRUE) {
		include 'menu_loged.php';
	}else{
		include 'menu.php';
	}
?>
<br>
<div class="container">
	<div class="left">
		<div class="central">
	<div class="row">
	<form action="results.php" method="GET">
		<h1 id="pesq">Pesquisa:<img src="img/lupa.JPG" id="lupa"></h1>
		<label for="car">Automóvel:</label><br/>
		<input type="text" name="marca" id="marca" placeholder="marca" /><br/>
		<input type="text" name="car" id="car" placeholder="nome" /><br/>
		<label for="car">Ano:</label><br>
		<input type="text" name="year1" id="year1" class="year" placeholder="de"/><br/>
		<input type="text" name="year2" id="year2" class="year" placeholder="até"/><br/>
		<input type="submit" id="botao" name="botao" value="Pesquisar"/>
	</form>
	</div>
	</div>
	</div>
</div>
</body>
</html>