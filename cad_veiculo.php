<?php session_start(); ?>
<!DOCTYPE html>
<?php
    
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] == 'FALSE') {
        header('location:login.php');
    }else{
        $title = "Cadastro de Veículos";
        include 'connect/connect.php';
        include 'acaoVeiculo.php';
        $acao = '';
        $codigo = '';
        $dados;
        if (isset($_GET["acao"]))
            $acao = $_GET["acao"];
        if ($acao == "editar"){
            if (isset($_GET["codigo"])){
                $codigo = $_GET["codigo"];
                $dados = carregaBDParaVetor($codigo); 
            }
        $sql = 'SELECT estado FROM '.$tb_cidade.' WHERE codigo='.$dados['cidade'];
        $result = mysqli_query($conexao,$sql);
        $row = mysqli_fetch_array($result);
        $codigo_estado = $row[0];
        }
    }
?>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <script type="text/javascript" src="ajax/func.js"></script>
</head>
<body>
    <form action="acaoVeiculo.php" id="form" method="post">
    <fieldset>
        <legend><?php echo $title; ?></legend>
        <input type="hidden" name="codigo" id="codigo" value="<?php if ($acao == "editar") echo $dados['codigo']; else echo "0";?>">  

        <label for="nome">Nome</label>     
        <input type="text" name="nome" id="nome" placeholder="Nome" value="<?php if ($acao == "editar") echo $dados['nome'];?>"><br>

        <label for="marca">marca</label>
        <select name="marca" id="marca">
        <?php 
            $sql = 'SELECT * FROM '.$tb_marca.' ORDER by nome';
            $result = mysqli_query($conexao,$sql);
            //echo $sql;
            while ($row = mysqli_fetch_array($result)){
                echo '<option value="'.$row['codigo'].'"';
                if ($acao == "editar" && $dados['marca'] == $row['codigo'])
                    echo ' selected';
                echo '>'.$row['nome'].'</option>';
            }
        ?>      
        </select><br>

        <label for='estado'>Estado</label>
        <select name="estado" id="estado" onchange="cidadePorEstado();">
        <option></option>
        <?php 
            $sql = 'SELECT * FROM '.$tb_estado.' ORDER by nome';
            $result = mysqli_query($conexao,$sql);
            //echo $sql;
            while ($row = mysqli_fetch_array($result)){
                echo '<option value="'.$row['codigo'].'"';
                if ($acao == "editar" && $codigo_estado == $row['codigo'])
                    echo ' selected';
                echo '>'.$row['nome'].'</option>';
            }
        ?></select>

        <label for="cidade">Cidade</label>
        <select name="cidade" id="cidade" required> 
        <option></option>   
        <?php 
            if ($acao == "editar") {
                $sql = 'SELECT * FROM '.$tb_cidade.' WHERE estado='.$codigo_estado.' ORDER by nome';
                $result = mysqli_query($conexao,$sql);
                //echo $sql;
                while ($row = mysqli_fetch_array($result)){
                    echo '<option value="'.$row['codigo'].'"';
                    if ($dados['cidade'] == $row['codigo'])
                        echo ' selected';
                    echo '>'.$row['nome'].'</option>';
                }
            }
        ?>
        </select><br>

        <label for="proprietario">Proprietário</label>
        <input type="hidden" name="proprietario" id="proprietario" value=<?php echo $_SESSION['codigo']; ?>><br><?php echo $_SESSION['nome']; ?><br>

        <label for="fabricacao">Fabricação</label>     
        <input type="text" name="fabricacao" id="fabricacao" placeholder="Fabricação" value="<?php if ($acao == "editar") echo $dados['fabricacao'];?>"><br>

        <label for="modelo_ano">Modelo do ano</label>     
        <input type="text" name="modelo_ano" id="modelo_ano" placeholder="Modelo do ano" value="<?php if ($acao == "editar") echo $dados['modelo_ano'];?>"><br>

        <label for="valor">Valor</label>     
        <input type="text" name="valor" id="valor" placeholder="Valor" value="<?php if ($acao == "editar") echo $dados['valor'];?>"><br>

        <label for="quilometragem">Quilometragem</label>     
        <input type="text" name="quilometragem" id="Quilometragem" placeholder="quilometragem" value="<?php if ($acao == "editar") echo $dados['quilometragem'];?>"><br>

        <label for="n_chassi">Número do chassi</label>     
        <input type="text" name="n_chassi" id="n_chassi" placeholder="Número do chassi" value="<?php if ($acao == "editar") echo $dados['n_chassi'];?>"><br>

        <label for="descricao">Descrição</label>
        <textarea name="descricao" id="descricao" placeholder="Descrição"><?php if ($acao == "editar") echo $dados['descricao'];?></textarea>

        <br><br>
        <button name="acao" value="salvar" id="acao" 
        type="submit">Salvar</button>
        <a href="list_veiculo.php">Consultar</a><br>
        <a href="loged.php">Voltar ao home</a><br>
        <a href="cad_marca.php">Cadastrar marca</a><br>       
    </fieldset>
    </form>
</body>
</html>