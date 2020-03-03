<?php
    session_start();
    if (!isset($_SESSION['logado']) || $_SESSION['logado']=="FALSE") {
        header('location:login.php');
    }
?>
<!DOCTYPE html>
<?php 
    $title = "Cadastro de Marcas";
   include 'connect/connect.php';
    include 'acaoMarca.php';
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
    }
?>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>        
</head>
<body>
    <form action="acaoMarca.php" id="form" method="post">
    <fieldset>
        <legend><?php echo $title; ?></legend>
        <label for="nome">Nome</label>
        <input type="hidden" name="codigo" id="codigo" value="<?php if ($acao == "editar") echo $dados['codigo']; else echo "0";?>">
        <input type="text" name="nome" id="nome" value="<?php if ($acao == "editar") echo $dados['nome'];?>"
        placeholder="Nome" required="true">	                        
        <br><br>
        <button name="acao" value="salvar" id="acao" 
        type="submit">Salvar</button>
        <a href="list_marca.php">Consultar</a><br>
        <a href="loged.php">Voltar ao home</a><br>
    </fieldset>
    </form>
</body>
</html>