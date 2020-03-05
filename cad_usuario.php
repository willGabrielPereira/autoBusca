<?php 
    session_start();
 ?>
<!DOCTYPE html>
<?php
    $title = "Cadastro de Usuários";
    include 'connect/connect.php';
    include 'acaoUsuario.php';
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

    if (isset($_POST['acao'])) {
        $dados = login($_POST['apelido'],$_POST['senha'],$tb_usuario);
        //var_dump($dados);
        if ($dados['logado'] == "TRUE") {
            $_SESSION['logado'] = $dados['logado'];
            $_SESSION['codigo'] = $dados['codigo'];
            $_SESSION['nome'] = $dados['nome'];
            $_SESSION['cpf'] = $dados['cpf'];
            $_SESSION['cidade'] = $dados['cidade'];
            $_SESSION['senha'] = $dados['senha'];
            $_SESSION['apelido'] = $dados['apelido'];
            $_SESSION['sexo'] = $dados['sexo'];
            $_SESSION['email'] = $dados['email'];
            $_SESSION['nascimento'] = $dados['nascimento'];
            $_SESSION['telefone'] = $dados['telefone'];
        }
    }
?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
    <title><?php echo $title; ?></title>
    <style>
        body{
            background-image: url('img/cadastropessoa.jpg');
        }
    </style>

    <script>
       function validaSenha (input){ 
            if (input.value != document.getElementById('senha').value) {
            input.setCustomValidity('Repita a senha corretamente');
          } else {
            input.setCustomValidity('');
          }
        } 
    </script>
    <script type="text/javascript" src="ajax/func.js"></script>
</head>
<body>
    <?php 
    if (isset($_SESSION['logado']) && $_SESSION['logado'] == "TRUE"){
        include 'menu_loged.php';   
    }else{
        include 'menu.php';
    } ?>
    <br>
    <div class="container">
  <div class="central">
  <div align='left'>
    <form action="acaoUsuario.php" id="form" method="post">
        <h1><?php echo $title; ?></h1>
        <input type="hidden" name="codigo" id="codigo" value="<?php if ($acao == "editar") echo $dados['codigo']; else echo "0";?>">  
            
        <input type="text" name="nome" id="nome" placeholder="Nome" value="<?php if ($acao == "editar") echo $dados['nome'];?>" required><br>
            
        <input type="text" name="cpf" id="cpf" placeholder="CPF" value="<?php if ($acao == "editar") echo $dados['cpf'];?>" required><br>
            
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
        <input type="password" name="senha" id="senha" placeholder="Senha" required><br>
           
        <input type="password" name="senhaR" id="senhaR" placeholder="Repita a sua senha" oninput="validaSenha(this)" required><br>
            
        <input type="text" name="apelido" id="apelido" placeholder="Apelido" value="<?php if ($acao == "editar") echo $dados['apelido'];?>" required><br>
            
        <select name="sexo" id="sexo" required>
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
        </select>
        <br>
        <input type="email" name="email" id="email" placeholder="E-mail" value="<?php if ($acao == "editar") echo $dados['email'];?>" required><br>
            
        <input type="date" name="nascimento" id="nascimento" placeholder="Nascimento" value="<?php if ($acao == "editar") echo date("Y-m-d", strtotime($dados['nascimento']));?>" required><br>
            
        <input type="text" name="telefone" id="telefone" placeholder="Telefone" value="<?php if ($acao == "editar") echo $dados['telefone'];?>" required><br>
        <br><br>
        <button name="acao" value="salvar" id="acao" 
        type="submit">Salvar</button>
    </form>
</div>
</div>
</div>
</body>
</html>