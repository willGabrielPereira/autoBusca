<?php
	session_start();
	if (isset($_GET['sair']) && $_GET['sair'] == "TRUE") {
		session_unset();
		session_destroy();
	}
  include 'connect/connect.php';

?>
<!DOCTYPE html>
<html>
<?php
	if (!isset($_SESSION['logado']) || $_SESSION['logado'] == 'FALSE') {
		header('location:login.php');
	}else {
        include "acaoUsuario.php";
        carregaBDParaVetor($_SESSION['codigo']);

        $dados['logado'] = $_SESSION['logado'];
      	$dados['codigo'] = $_SESSION['codigo'];
      	$dados['nome'] = $_SESSION['nome'];
      	$dados['cpf'] = $_SESSION['cpf'];
      	$dados['cidade'] = $_SESSION['cidade'];
      	$dados['senha'] = $_SESSION['senha'];
      	$dados['apelido'] = $_SESSION['apelido'];
      	$dados['sexo'] = $_SESSION['sexo'];
      	$dados['email'] = $_SESSION['email'];
      	$dados['nascimento'] = $_SESSION['nascimento'];
      	$dados['telefone'] = $_SESSION['telefone'];
	}
?>
<script>
        function excluirRegistro(url) {
            if (confirm("Confirmar Exclusão?"))
                location.href = url;
        }
</script>
<head>
  <link rel="stylesheet" href="css/css.css">
	<title>Home</title>
</head>
<body>
<div class="container">
<div class="row">
  <div class="col col-4">
	 <div class="teste"><a href="cad_veiculo.php">Cadastrar veículo</a><br>
	 <div class="teste"><a href="cad_marca.php">Cadastrar marca</a><br></div>
	 <div class="teste"><a href="list_veiculo.php">Lista de todos os veículos</a><br></div>
	 <div class="teste"><a href="loged.php?sair=TRUE">Sair</a></div>
</div>
<br>
<div align="left">
<?php

  $sql = 'SELECT nome FROM '.$tb_cidade.' WHERE codigo = '.$dados['cidade'];
  $result = mysqli_query($conexao,$sql);
  //echo $sql;
  $dados['cidade'] = mysqli_fetch_array($result);
	echo "<h1>Olá ".$dados['nome'].'. Aqui estão os seus dados:</h1>';
	echo "
	<table border='1px' width='100%'>
		<tr>
			<th align='center'><b>Código</b></th>
            <th align='left'><b>Nome</b></th> 
            <th align='left'><b>CPF</b></th> 
            <th align='left'><b>Localização</b></th>
            <th align='left'><b>Apelido</b></th> 
            <th align='left'><b>Sexo</b></th> 
            <th align='left'><b>E-mail</b></th>
            <th align='left'><b>Nascimento</b></th>
            <th align='left'><b>Telefone</b></th>
            <th width='20'><b>Alterar</b></th>
        </tr>
        <tr>
        	<td>".$dados['codigo']."</td>
        	<td>".$dados['nome']."</td>
        	<td>".$dados['cpf']."</td>
        	<td>".$dados['cidade']['nome']."</td>
        	<td>".$dados['apelido']."</td>
        	<td>".$dados['sexo']."</td>
        	<td>".$dados['email']."</td>
        	<td>".date("d/m/Y", strtotime($dados['nascimento']))."</td>
        	<td>".$dados['telefone']."</td>
        	<td><a href='cad_usuario.php?acao=editar&codigo=".$dados['codigo']."'><img src='img/form/edit.png'></a></td>
        	</tr>
        </table>";
?>
</div>
<div align="left">
	<?php
		$sql = 'SELECT * FROM '.$tb_cidade.', '.$tb_veiculo.', '.$tb_usuario.', '.$tb_marca.
                   ' WHERE '.$tb_cidade.'.codigo = '.$tb_veiculo.'.localidade'.
                   ' AND '.$tb_usuario.'.codigo = '.$tb_veiculo.'.proprietario'.
                   ' AND '.$tb_marca.'.codigo = '.$tb_veiculo.'.marca'.
                   ' AND '.$tb_usuario.'.nome LIKE "'.$dados['nome'].
                   '%" ORDER BY '.$tb_veiculo.'.nome';
        $result = mysqli_query($conexao,$sql);

	?>
	<h1>Seus carros</h1>
	<table border="1px" width='100%'>
	    <tr><th align="center"><b>Código</b></th>
            <th align="left"><b>Nome</b></th> 
            <th align="left"><b>Marca</b></th> 
            <th align="left"><b>Fabricação</b></th> 
            <th align="left"><b>Modelo do ano</b></th> 
            <th align="left"><b>Valor</b></th> 
            <th align="left"><b>Descrição</b></th>
            <th align="left"><b>Localização</b></th>
            <th align="left"><b>Quilometragem</b></th>
            <th align="left"><b>Proprietário</b></th>
            <th align="left"><b>Número do chassi</b></th>
            <th align="left"><b>Alterar</b></th>
            <th align="left"><b>Excluir</b></th>
	    </tr>
	    <?php while ($row = mysqli_fetch_array($result)){ 
        mb_convert_encoding($row[1], "utf-8"); ?>
	    <tr>    
            <td align="center"><?php echo $row[3];?></td>
            <td><?php echo $row[5];?></td>
            <td><?php echo $row[27];?></td>
            <td><?php echo $row['fabricacao'];?></td>
            <td><?php echo $row[7];?></td>
            <td><?php echo $row[8];?></td>
            <td><?php echo $row[9];?></td>
            <td><?php echo $row[1];?></td>
            <td><?php echo $row[11];?></td>
            <td><?php echo $row[16];?></td>
            <td><?php echo $row['n_chassi'];?></td>
            <td><a href="cad_veiculo.php?acao=editar&codigo=<?php echo $row[3];?>"><img src="img/form/edit.png"></a></td>
            <td><a href="javascript:excluirRegistro('acaoVeiculo.php?acao=excluir&codigo=<?php echo $row[3];?>')"><img src="img/form/delete.png"></a></td>
	    </tr>
	    <?php } ?>
</div>
<br>
</div>
</body>
</html>