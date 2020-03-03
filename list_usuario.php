<!DOCTYPE html>
<?php 
    include 'connect/connect.php';
	$title = "Lista de Usuários";
    $procurar = '';
	if (isset($_POST["procurar"]))
        $procurar = $_POST["procurar"];
    $busca = 2;
    if (isset($_POST["busca"]))
        $busca = $_POST["busca"];
?>
<html>
<head>
    <meta charset="UTF-8">
    <title> <?php echo $title; ?> </title>
    <script>
        function excluirRegistro(url) {
            if (confirm("Confirmar Exclusão?"))
                location.href = url;
        }
    </script>
</head>
<body>
    <form method="post">
    <fieldset>
        <legend><?php echo $title; ?></legend>
        <input type="text"   name="procurar" list="usuarios"
               id="procurar" size="37" value="<?php echo $procurar;?>">
        <datalist id="usuarios">
        <?php 
            $sql = 'SELECT * FROM '.$tb_usuario;
            $result = mysqli_query($conexao,$sql);
            while ($row = mysqli_fetch_array($result))
                echo '<option value="'.$row['nome'].'">';
        ?>
        </datalist>
        <input type="submit" name="acao" id="acao">
        <input type="radio" name="busca" id="busca" value="1" 
               <?php if ($busca == 1) echo 'checked';?>>Busca por Localização
        <input type="radio" name="busca" id="busca" value="2" 
               <?php if ($busca == 2) echo 'checked';?>>Busca por Usuário
        <a href="cad_usuario.php">Novo usuário</a>
        <br><br>
        <table width="90%">
	    <tr><th align="center"><b>Código</b></th>
            <th align="left"><b>Nome</b></th> 
            <th align="left"><b>CPF</b></th> 
            <th align="left"><b>Localização</b></th> 
            <th align="left"><b>Senha</b></th> 
            <th align="left"><b>Apelido</b></th> 
            <th align="left"><b>Sexo</b></th> 
            <th align="left"><b>E-mail</b></th>
            <th align="left"><b>Nascimento</b></th>
            <th align="left"><b>Telefone</b></th>
            <th width="20"><b>Alterar</b></th>
            <th width="20"><b>Excluir</b></th>
	    </tr>
        <?php
            if ($busca == 1){ 
            $sql = 'SELECT * FROM '.$tb_cidade.', '.$tb_usuario.
                   ' WHERE '.$tb_cidade.'.codigo = '.$tb_usuario.'.localidade'.
                   ' AND '.$tb_cidade.'.nome LIKE "'.$procurar.
                   '%" ORDER BY '.$tb_usuario.'.nome';
            }
            else{
            $sql = 'SELECT * FROM '.$tb_cidade.', '.$tb_usuario.
                   ' WHERE '.$tb_cidade.'.codigo = '.$tb_usuario.'.localidade'.
                   ' AND '.$tb_usuario.'.nome LIKE "'.$procurar.
                   '%" ORDER BY '.$tb_usuario.'.nome';
            }
            $result = mysqli_query($conexao,$sql);
	        $cont = 0;
            //echo $sql;
            while ($row = mysqli_fetch_array($result)){ 
            if ($cont % 2 == 0)
                echo '<tr>';
            else
                echo '<tr class="sombra">';
            $cont++;     
        ?>
	        <td align="center"><?php echo $row['codigo'];?></td>
            <td><?php echo $row['nome'];?></td>
            <td><?php echo $row['cpf'];?></td>
            <td><?php echo $row[1];?></td>
            <td><?php echo $row[7];?></td>
            <td><?php echo $row[8];?></td>
            <td><?php echo $row[9];?></td>
            <td><?php echo $row[10];?></td>
            <td><?php echo $row[11];?></td>
            <td><?php echo $row[12];?></td>
            <td align="center"><a href="cad_usuario.php?acao=editar&codigo=<?php echo $row['codigo'];?>"><img src="img/form/edit.png"></a></td>
            <td align="center"><a href="javascript:excluirRegistro('acaoUsuario.php?acao=excluir&codigo=<?php echo $row['codigo'];?>')"><img src="img/form/delete.png"></a></td>
	    </tr>
            <?php } ?>       
        </table>
    </fieldset>
    </form>
</body>
</html>