<!DOCTYPE html>
<?php 
    include 'connect/connect.php';
	$title = "Lista de Marcas";
    $procurar = '';
	if (isset($_POST["procurar"]))
        $procurar = $_POST["procurar"];
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
        <input type="text"   name="procurar" list="marcas"
               id="procurar" size="37" value="<?php echo $procurar;?>">
        <datalist id="marcas">
        <?php 
            $sql = 'SELECT * FROM '.$tb_marca;
            $result = mysqli_query($conexao,$sql);
            while ($row = mysqli_fetch_array($result))
                echo '<option value="'.$row['nome'].'">';
        ?>
        </datalist>
        <input type="submit" name="acao" id="acao">
        <a href="cad_marca.php">Nova Marca</a>
        <br><br>
        <table>
	    <tr><th><b>Código</b></th>
            <th><b>Nome</b></th> 
            <th><b>Alterar</b></th>
            <th><b>Excluir</b></th>
	    </tr>
        <?php
            $sql = 'SELECT * FROM '.$tb_marca.
                   ' WHERE nome LIKE "'.$procurar.
                   '%" ORDER BY nome';
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
	        <td><?php echo $row['codigo'];?></td>
            <td><?php echo $row['nome'];?></td>            
            <td><a href="cad_marca.php?acao=editar&codigo=<?php echo $row['codigo'];?>"><img src="img/form/edit.png"></a></td>
            <td><a href="javascript:excluirRegistro('acaoMarca.php?acao=excluir&codigo=<?php echo $row['codigo'];?>')"><img src="img/form/delete.png"></a></td>
	    </tr>
            <?php } ?>       
        </table>
    </fieldset>
    </form>
</body>
</html>