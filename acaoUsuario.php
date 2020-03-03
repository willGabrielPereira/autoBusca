<?php
	//session_start();
	header('Content-Type: text/html; charset=UTF-8');
	include 'connect/connect.php';
	include 'conf/conf.inc.php';
	$tb_usuario = "usuario";	
	$acao = '';
	if (isset($_GET["acao"]))
		  $acao = $_GET["acao"];
	
	if ($acao == "excluir"){
		$codigo = 0;
		if (isset($_GET["codigo"])){
		  	$codigo = $_GET["codigo"];
			excluir($codigo);
		}
	}else{
		if (isset($_POST["acao"])){
			$acao = $_POST["acao"];
			if ($acao == "salvar"){
				$codigo = 0;
				if (isset($_POST["codigo"])){
					$codigo = $_POST["codigo"];
					if ($codigo == 0)
					inserir();
					else
					alterar($codigo);
				}
			}
		}
	}
	
	function login($login, $senha, $tb_usuario){
		//echo "<h1>chegou</h1>";
		$senha = sha1($senha);
		$sql = "SELECT * FROM ".$tb_usuario." WHERE apelido = '".$login."' AND senha = '".$senha."'";

		$result = mysqli_query($GLOBALS['conexao'], $sql);
		if (mysqli_num_rows($result) != 0) {
			$dados['logado'] = "TRUE";
			while ($row = mysqli_fetch_array($result)){
				$dados['codigo'] = $row["codigo"];
				$dados['nome'] = $row["nome"];
				$dados['cpf'] = $row["cpf"];
				$dados['cidade'] = $row["localidade"];
				$dados['senha'] = $row["senha"];
				$dados['apelido'] = $row["apelido"];
				$dados['sexo'] = $row["sexo"];
				$dados['email'] = $row["email"];
				$dados['nascimento'] = $row["nascimento"];
				$dados['telefone'] = $row["telefone"];
			}
		}else{
			$dados['logado'] = "FALSE";
		}
		return $dados;
	}

	function excluir($codigo){
		$sql ='DELETE FROM '.$GLOBALS['tb_veiculo'].' WHERE proprietario='.$codigo;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		
		$sql = 'DELETE FROM '.$GLOBALS['tb_usuario'].
		       ' WHERE codigo =  '.$codigo;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		header("location:list_usuario.php");
	}

	function alterar($codigo){
		$vet = carregarTelaParaVetor();
		$sql = 'UPDATE '.$GLOBALS['tb_usuario'].
		       ' SET nome = "'.$vet['nome'].'"'.
		       ', cpf = "'.$vet['cpf'].
		       '", localidade = '.$vet['localidade'].
		       ', senha = "'.$vet['senha'].
		       '", apelido = "'.$vet['apelido'].
		       '", sexo = "'.$vet['sexo'].
		       '", email = "'.$vet['email'].
		       '", nascimento = "'.$vet['nascimento'].
		       '", telefone = "'.$vet['telefone'].
		       '" WHERE codigo = '.$codigo;
		//echo $sql;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		header("location:cad_usuario.php?acao=editar&codigo=$codigo");
	}
	
	function inserir(){	
		$vet = carregarTelaParaVetor();
		$sql = 'INSERT INTO '.$GLOBALS['tb_usuario'].
		       ' (nome, cpf, localidade, senha, apelido, sexo, email, nascimento, telefone)'.
		       ' VALUES ("'.$vet['nome'].'","'.$vet['cpf'].'","'.$vet['localidade'].'","'.$vet['senha'].'","'.$vet['apelido'].'","'.$vet['sexo'].'","'.$vet['email'].'","'.$vet['nascimento'].'","'.$vet['telefone'].'")';
		       //echo $sql;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		//$codigo = mysqli_insert_id($GLOBALS['conexao']);
		header("location:login.php?salvar=TRUE");
	}
	
	function carregarTelaParaVetor(){
		$vet = array();
		$vet['codigo'] = $_POST["codigo"];
		$vet['nome'] = $_POST["nome"];
		$vet['cpf'] = $_POST["cpf"];
		$vet['localidade'] = $_POST["cidade"];
		$vet['senha'] = sha1($_POST["senha"]);
		$vet['apelido'] = $_POST["apelido"];
		$vet['sexo'] = $_POST["sexo"];
		$vet['email'] = $_POST["email"];
		$vet['nascimento'] = isset($_POST['nascimento'])
							? str_replace("/", "-", $_POST['nascimento'])
							: "24-04-1978";
		$vet['telefone'] = $_POST["telefone"];
		//var_dump($vet);
		return $vet;		
	}	
		
	function carregaBDParaVetor($codigo){
		$sql = 'SELECT * FROM '.$GLOBALS['tb_usuario'].
		       ' WHERE codigo = '.$codigo;
		//echo $sql;       
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		$dados = array();
		while ($row = mysqli_fetch_array($result)){
			$dados['logado'] = "TRUE";
			$dados['codigo'] = $row["codigo"];
			$dados['nome'] = $row["nome"];
			$dados['cpf'] = $row["cpf"];
			$dados['cidade'] = $row["localidade"];
			$dados['senha'] = $row["senha"];
			$dados['apelido'] = $row["apelido"];
			$dados['sexo'] = $row["sexo"];
			$dados['email'] = $row["email"];
			$dados['nascimento'] = $row["nascimento"];
			$dados['telefone'] = $row["telefone"];
		}  
		//var_dump($dados);
		secaoToDados($dados);
		return $dados;    		
	}
	function secaoToDados($dados){
		$_SESSION['logado'] = $dados['logado'];
      	$_SESSION['codigo'] = $dados['codigo'];
      	$_SESSION['nome'] = $dados['nome'];
      	$_SESSION['cpf'] = $dados['cpf'];
      	$_SESSION['cidade'] = $dados['cidade'];
      	$_SESSION['senha'] = $dados['senha'];
      	$_SESSION['apelido'] = $dados['apelido'];
      	$_SESSION['sexo'] = $dados['sexo'];
      	$_SESSION['email'] = $dados['email'];
      	$_SESSION['nascimento'] = $dados['nascimento'];
      	$_SESSION['telefone'] = $dados['telefone'];
	}
?>	