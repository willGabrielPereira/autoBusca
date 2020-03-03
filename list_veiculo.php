<!DOCTYPE html>
<?php 
    include 'connect/connect.php';
	$title = "Lista de Veículos";
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
        <input type="text"   name="procurar" list="veiculos"
               id="procurar" size="37" value="<?php echo $procurar;?>">
        <datalist id="veiculos">
        <?php 
            $sql = 'SELECT * FROM '.$tb_veiculo;
            $result = mysqli_query($conexao,$sql);
            while ($row = mysqli_fetch_array($result))
                echo '<option value="'.$row['nome'].'">';
        ?>
        </datalist>
        <input type="submit" name="acao" id="acao">
        <input type="radio" name="busca" id="busca" value="1" 
               <?php if ($busca == 1) echo 'checked';?>>Busca por Localização
        <input type="radio" name="busca" id="busca" value="2" 
               <?php if ($busca == 2) echo 'checked';?>>Busca por Veículo
        <input type="radio" name="busca" id="busca" value="3" 
               <?php if ($busca == 3) echo 'checked';?>>Busca por Dono
        <br><br>
        <table width="90%">
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
	    </tr>
        <?php
            if ($busca == 1){ 
            $sql = 'SELECT * FROM '.$tb_cidade.', '.$tb_veiculo.', '.$tb_usuario.', '.$tb_marca.
                   ' WHERE '.$tb_cidade.'.codigo = '.$tb_veiculo.'.localidade'.
                   ' AND '.$tb_usuario.'.codigo = '.$tb_veiculo.'.proprietario'.
                   ' AND '.$tb_marca.'.codigo = '.$tb_veiculo.'.marca'.
                   ' AND '.$tb_cidade.'.nome LIKE "'.$procurar.
                   '%" ORDER BY '.$tb_veiculo.'.nome';
            }
            elseif($busca == 2){
            $sql = 'SELECT * FROM '.$tb_cidade.', '.$tb_veiculo.', '.$tb_usuario.', '.$tb_marca.
                   ' WHERE '.$tb_cidade.'.codigo = '.$tb_veiculo.'.localidade'.
                   ' AND '.$tb_usuario.'.codigo = '.$tb_veiculo.'.proprietario'.
                   ' AND '.$tb_marca.'.codigo = '.$tb_veiculo.'.marca'.
                   ' AND '.$tb_veiculo.'.nome LIKE "'.$procurar.
                   '%" ORDER BY '.$tb_veiculo.'.nome';
            }else{
            $sql = 'SELECT * FROM '.$tb_cidade.', '.$tb_veiculo.', '.$tb_usuario.', '.$tb_marca.
                   ' WHERE '.$tb_cidade.'.codigo = '.$tb_veiculo.'.localidade'.
                   ' AND '.$tb_usuario.'.codigo = '.$tb_veiculo.'.proprietario'.
                   ' AND '.$tb_marca.'.codigo = '.$tb_veiculo.'.marca'.
                   ' AND '.$tb_usuario.'.nome LIKE "'.$procurar.
                   '%" ORDER BY '.$tb_veiculo.'.nome';
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
	    </tr>
            <?php } ?>    
        </table>
        <a href="index.php">Voltar ao home</a>
    </fieldset>
    </form>
</body>
</html>