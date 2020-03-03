<?php
	header('Content-Type: text/html; charset=UTF-8');
	include 'connect/connect.php';
	
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
	
	function excluir($codigo){
		$sql = 'DELETE FROM '.$GLOBALS['tb_marca'].
		       ' WHERE codigo =  '.$codigo;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		header("location:list_marca.php");
	}

	function alterar($codigo){
		$vet = carregarTelaParaVetor();
		$sql = 'UPDATE '.$GLOBALS['tb_marca'].
		       ' SET nome = "'.$vet['nome'].
		       '" WHERE codigo = '.$codigo;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		header("location:cad_marca.php?acao=editar&codigo=$codigo");
	}
	
	function inserir(){	
		$vet = carregarTelaParaVetor();
		$sql = 'INSERT INTO '.$GLOBALS['tb_marca'].
		       ' (nome) VALUES ("'.$vet['nome'].'")';
		echo $sql;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		header("location:cad_marca.php");
	}
	
	function carregarTelaParaVetor(){
		$vet = array();
		$vet['codigo'] = $_POST["codigo"];
		$vet['nome'] = $_POST["nome"];
		return $vet;		
	}	
		
	function carregaBDParaVetor($codigo){
		$sql = 'SELECT * FROM '.$GLOBALS['tb_marca'].
		       ' WHERE codigo = '.$codigo;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		$dados = array();
		while ($row = mysqli_fetch_array($result)){
			$dados['codigo'] = $row['codigo'];
			$dados['nome'] = $row['nome'];
		}   
		return $dados;    		
	}
?>	