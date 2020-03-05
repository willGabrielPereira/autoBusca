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
    <style>
        body{
            background-image: url('img/cad_veiculo.jpg');
        }
    </style>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <script type="text/javascript" src="ajax/func.js"></script>
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
</head>
<body>
    <?php 
        include 'menu_loged.php';
    ?>
    <br>
    <div class="container">
        <div class="central">
    <form action="acaoVeiculo.php" id="form" method="post">
        <h1 class="cad_carro"><?php echo $title; ?></h1>
        <input type="hidden" name="codigo" id="codigo" value="<?php if ($acao == "editar") echo $dados['codigo']; else echo "0";?>">  

        <input type="text" name="nome" id="nome" placeholder="Nome automóvel" value="<?php if ($acao == "editar") echo $dados['nome'];?>"><br>

        <select name="marca" id="marca">
        <option>Marca</option>
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

        <select name="estado" id="estado" onchange="cidadePorEstado();">
        <option>Estado</option>
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
        ?></select><br>

        <select name="cidade" id="cidade" required> 
        <option>Cidade</option>   
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

        <input type="hidden" name="proprietario" id="proprietario" value="<?php echo $_SESSION['codigo']; ?>">
        <input type='text' value="<?php echo $_SESSION['nome']; ?>" disabled><br>

        <input type="text" name="fabricacao" id="fabricacao" placeholder="Ano de fabricação" value="<?php if ($acao == "editar") echo $dados['fabricacao'];?>"><br>

        <input type="text" name="modelo_ano" id="modelo_ano" placeholder="Ano do modelo" value="<?php if ($acao == "editar") echo $dados['modelo_ano'];?>"><br>

        <input type="text" name="valor" id="valor" placeholder="Valor" value="<?php if ($acao == "editar") echo $dados['valor'];?>"><br>

        <input type="text" name="quilometragem" id="Quilometragem" placeholder="quilometragem" value="<?php if ($acao == "editar") echo $dados['quilometragem'];?>"><br>

        <input type="text" name="n_chassi" id="n_chassi" placeholder="Número do chassi" value="<?php if ($acao == "editar") echo $dados['n_chassi'];?>"><br>

        <textarea name="descricao" id="descricao" placeholder="Descrição"><?php if ($acao == "editar") echo $dados['descricao'];?></textarea>

        <br><br>
        <button name="acao" value="salvar" id="acao" 
        type="submit">Salvar</button>
    </form>
    </div>
</div>
</body>
</html>