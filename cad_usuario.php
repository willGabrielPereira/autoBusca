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
    <title><?php echo $title; ?></title>
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
    <form action="acaoUsuario.php" id="form" method="post">
    <fieldset>
        <legend><?php echo $title; ?></legend>
        <input type="hidden" name="codigo" id="codigo" value="<?php if ($acao == "editar") echo $dados['codigo']; else echo "0";?>">  

        <label for="nome">Nome</label>     
        <input type="text" name="nome" id="nome" placeholder="Nome" value="<?php if ($acao == "editar") echo $dados['nome'];?>" required><br>

        <label for="cpf">CPF</label>     
        <input type="text" name="cpf" id="cpf" placeholder="CPF" value="<?php if ($acao == "editar") echo $dados['cpf'];?>" required><br>

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

        <label for="senha">Senha</label>     
        <input type="password" name="senha" id="senha" placeholder="Senha" required><br>

        <label for="senhaR">Repita sua senha</label>     
        <input type="password" name="senhaR" id="senhaR" placeholder="Repita a sua senha" oninput="validaSenha(this)" required><br>

        <label for="apelido">Apelido</label>     
        <input type="text" name="apelido" id="apelido" placeholder="Apelido" value="<?php if ($acao == "editar") echo $dados['apelido'];?>" required><br>

        <select name="sexo" id="sexo" required>
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
        </select>

        <label for="email">E-mail</label>     
        <input type="email" name="email" id="email" placeholder="E-mail" value="<?php if ($acao == "editar") echo $dados['email'];?>" required><br>

        <label for="nascimento">Nascimento</label>     
        <input type="date" name="nascimento" id="nascimento" placeholder="Nascimento" value="<?php if ($acao == "editar") echo date("Y-m-d", strtotime($dados['nascimento']));?>" required><br>

        <label for="telefone">Telefone</label>     
        <input type="text" name="telefone" id="telefone" placeholder="Telefone" value="<?php if ($acao == "editar") echo $dados['telefone'];?>" required><br>
        <br><br>
        <button name="acao" value="salvar" id="acao" 
        type="submit">Salvar</button>
        <?php if (isset($_GET['acao']) && $_GET['acao']=="editar") {
            echo "<a href='login.php'>Voltar ao home</a>";
        }else{
            echo "<a href='login.php'>Fazer login</a>";
        } ?>
        </fieldset>
    </form>
</body>
</html>