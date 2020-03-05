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
  <style>
        body{
            background-image: url('img/loged.jpg');
        }
    </style>
  <link rel="stylesheet" href="css/css.css">
	<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
  <title>Home</title>
</head>
<body>
  <?php 
    include 'menu_loged.php';
  ?>
<br>
<div class="container">
<div align="left">
<?php

  $sql = 'SELECT nome FROM '.$tb_cidade.' WHERE codigo = '.$dados['cidade'];
  $result = mysqli_query($conexao,$sql);
  //echo $sql;
  $dados['cidade'] = mysqli_fetch_array($result);
	echo "<div class='dados'><h1>Olá ".$dados['nome'].'. Aqui estão os seus dados:</h1><br>';
	echo "
	<table border='0px' width='100%'>
		<tr>
			<th align='center'><b>Código</b></th>
            <th align='center'><b>Nome</b></th> 
            <th align='center'><b>CPF</b></th> 
            <th align='center'><b>Localização</b></th>
            <th align='center'><b>Apelido</b></th> 
            <th align='center'><b>Sexo</b></th> 
            <th align='center'><b>E-mail</b></th>
            <th align='center'><b>Nascimento</b></th>
            <th align='center'><b>Telefone</b></th>
            <th width='20'><b>Alterar</b></th>
        </tr>
        <tr>
        	<td align='center'>".$dados['codigo']."</td>
        	<td align='center'>".$dados['nome']."</td>
        	<td align='center'>".$dados['cpf']."</td>
        	<td align='center'>".$dados['cidade']['nome']."</td>
        	<td align='center'>".$dados['apelido']."</td>
        	<td align='center'>".$dados['sexo']."</td>
        	<td align='center'>".$dados['email']."</td>
        	<td align='center'>".date("d/m/Y", strtotime($dados['nascimento']))."</td>
        	<td align='center'>".$dados['telefone']."</td>
        	<td align='center'><a href='cad_usuario.php?acao=editar&codigo=".$dados['codigo']."'><i class='fa fa-pencil-square-o fa-1x' aria-hidden='true'></a></td>
        	</tr>
        </table>
        </div>";
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
  <br>
  <br>
  <br>
  <div class="dados">
	<h1>Seus carros</h1>
	<table border="0px" width='100%'>
	    <tr><th align="center"><b>Código</b></th>
            <th align="center"><b>Nome</b></th> 
            <th align="center"><b>Marca</b></th> 
            <th align="center"><b>Fabricação</b></th> 
            <th align="center"><b>Modelo do ano</b></th> 
            <th align="center"><b>Valor</b></th> 
            <th align="center"><b>Descrição</b></th>
            <th align="center"><b>Localização</b></th>
            <th align="center"><b>Quilometragem</b></th>
            <th align="center"><b>Proprietário</b></th>
            <th align="center"><b>Número do chassi</b></th>
            <th align="center"><b>Alterar</b></th>
            <th align="center"><b>Excluir</b></th>
	    </tr>
	    <?php while ($row = mysqli_fetch_array($result)){ 
        mb_convert_encoding($row[1], "utf-8"); ?>
	    <tr>    
            <td align="center"><?php echo $row[3];?></td>
            <td align='center'><?php echo $row[5];?></td>
            <td align='center'><?php echo $row[27];?></td>
            <td align='center'><?php echo $row['fabricacao'];?></td>
            <td align='center'><?php echo $row[7];?></td>
            <td align='center'><?php echo $row[8];?></td>
            <td align='center'><?php echo $row[9];?></td>
            <td align='center'><?php echo $row[1];?></td>
            <td align='center'><?php echo $row[11];?></td>
            <td align='center'><?php echo $row[16];?></td>
            <td align='center'><?php echo $row['n_chassi'];?></td>
            <td align='center'><a href="cad_veiculo.php?acao=editar&codigo=<?php echo $row[3];?>"><i class="fa fa-pencil-square-o fa-1x" aria-hidden="true"></i></a></td>
            <td align='center'><a href="javascript:excluirRegistro('acaoVeiculo.php?acao=excluir&codigo=<?php echo $row[3];?>')"><i class="fa fa-trash fa-1x" aria-hidden="true"></a></td>
	    </tr>
	    <?php } ?>
      </div>
</div>
<br>
</div>
</body>
</html>