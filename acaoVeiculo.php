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
		$sql = 'DELETE FROM '.$GLOBALS['tb_veiculo'].
		       ' WHERE codigo =  '.$codigo;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		header("location:loged.php");
	}

	function alterar($codigo){
		$vet = carregarTelaParaVetor();
		$sql = 'UPDATE '.$GLOBALS['tb_veiculo'].
		       ' SET nome = "'.$vet['nome'].'"'.
		       ', marca = '.$vet['marca'].
		       ', localidade = '.$vet['localidade'].
		       ', fabricacao = "'.$vet['fabricacao'].
		       '", modelo_ano = "'.$vet['modelo_ano'].
		       '", valor = "'.$vet['valor'].
		       '", descricao = "'.$vet['descricao'].
		       '", quilometragem = "'.$vet['quilometragem'].
		       '", proprietario = '.$vet['proprietario'].
		       ', n_chassi = "'.$vet['n_chassi'].
		       '" WHERE codigo = '.$codigo;
		       //echo $sql;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		header("location:cad_veiculo.php?acao=editar&codigo=$codigo");
	}
	
	function inserir(){	
		$vet = carregarTelaParaVetor();
		$sql = 'INSERT INTO '.$GLOBALS['tb_veiculo'].
		       ' (nome, marca, localidade, fabricacao, modelo_ano, valor, descricao, quilometragem, proprietario, n_chassi)'.
		       ' VALUES ("'.$vet['nome'].'","'.$vet['marca'].'","'.$vet['localidade'].'","'.$vet['fabricacao'].'","'.$vet['modelo_ano'].'","'.$vet['valor'].'","'.$vet['descricao'].'","'.$vet['quilometragem'].'","'.$vet['proprietario'].'","'.$vet['n_chassi'].'")';
		       //echo $sql;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		$codigo = mysqli_insert_id($GLOBALS['conexao']);
		header("location:cad_veiculo.php?acao=editar&codigo=$codigo");
	}
	
	function carregarTelaParaVetor(){
		$vet = array();
		$vet['codigo'] = $_POST["codigo"];
		$vet['nome'] = $_POST["nome"];
		$vet['marca'] = $_POST["marca"];
		$vet['localidade'] = $_POST["cidade"];
		$vet['fabricacao'] = $_POST["fabricacao"];
		$vet['modelo_ano'] = $_POST["modelo_ano"];
		$vet['valor'] = $_POST["valor"];
		$vet['descricao'] = $_POST["descricao"];
		$vet['quilometragem'] = $_POST["quilometragem"];
		$vet['proprietario'] = $_POST["proprietario"];
		$vet['n_chassi'] = $_POST["n_chassi"];
		return $vet;		
	}	
		
	function carregaBDParaVetor($codigo){
		$sql = 'SELECT * FROM '.$GLOBALS['tb_veiculo'].
		       ' WHERE codigo = '.$codigo;
		//echo $sql;       
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		$dados = array();
		while ($row = mysqli_fetch_array($result)){
			$dados['codigo'] = $row["codigo"];
			$dados['nome'] = $row["nome"];
			$dados['marca'] = $row["marca"];
			$dados['cidade'] = $row["localidade"];
			$dados['fabricacao'] = $row["fabricacao"];
			$dados['modelo_ano'] = $row["modelo_ano"];
			$dados['valor'] = $row["valor"];
			$dados['descricao'] = $row["descricao"];
			$dados['quilometragem'] = $row["quilometragem"];
			$dados['proprietario'] = $row["proprietario"];
			$dados['n_chassi'] = $row["n_chassi"];
		}  
		//var_dump($dados);
		return $dados;    		
	}
?>	