<?php 
	session_start();
?>
<!DOCTYPE html>
<html>
<?php
	
    if (isset($_GET['salvar']) && $_GET['salvar']=="TRUE") {
        echo "<script>
        	alert('Cadastro concluído')
        </script>";
    }

    include 'connect/connect.php';
    $dados = '';
    include 'acaoUsuario.php';

    if (isset($_POST['acao'])) {
    	$dados = login($_POST['apelido'],$_POST['senha'],$tb_usuario);
    	//var_dump($dados);
      	if ($dados['logado'] == "TRUE") {
          secaoToDados($dados);
	    	header('location:loged.php');
	    }elseif ($dados['logado'] == "FALSE") {
	    	echo "<script>
	    			alert('Falha na autenticação');
	    		</script>";
	    }
    }

    if (isset($_SESSION['logado']) && $_SESSION['logado'] == "TRUE") {
      echo "<script>
            alert('Você já está logado');
          </script>";

      header('location:loged.php');
  }

    $title = "Fazer login";
?>
<head>
	<link rel="stylesheet" href="css/css.css" />
	<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>
	<style>
        body{
            background-image: url('img/loged.jpg');
        }
    </style>
</head>
<body>
	<?php 
    include 'menu.php';
  ?>
  <br>
	<div class="container">
  <div class="central">
  <div align='left'>
	<form action="login.php" method="post">
			<h1>Login</h1>
			<input type="text" name="apelido" id="apelido" placeholder="Apelido"><br>

			<input type="password" name="senha" id="senha" placeholder="Senha"><br>

			<button type="submit" name="acao" id="acao" value="login">Login</button><br>
			<button class="botao_inicial"><a href="cad_usuario.php">Não tenho conta</a></button>
			<button class="botao_inicial"><a href="index.php">Esqueci minha senha</a></button>
	</form>
  </div>
	</div>
  </div>
</body>
</html>