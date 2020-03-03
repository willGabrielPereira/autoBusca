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
	<link type="text/css"  href="css/css.css" />
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<form action="login.php" method="post">
		<fieldset>
			<legend>Login</legend>

			<label for='login'>Apelido</label>
			<input type="text" name="apelido" id="apelido" placeholder="apelido"><br>

			<label for="senha">Senha</label>
			<input type="password" name="senha" id="senha" placeholder="senha"><br>

			<input type="submit" name="acao" id="acao" value="login">
			<p><a href="cad_usuario.php">Não tenho conta</a></p>
			<p><a href="index.php">Voltar para principal</a></p>
		</fieldset>
	</form>
</body>
</html>