<?php
	include '../connect/connect.php';

	$codigo = $_POST['estado'];
	$sql = 'SELECT * FROM '.$tb_cidade.' WHERE estado='.$codigo.' ORDER by nome';
            $result = mysqli_query($conexao,$sql);
            //echo '<option>'.$sql.'</option>';
    while ($row = mysqli_fetch_array($result)){
    	echo '<option value="'.$row['codigo'].'"';
    		echo '>'.$row['nome'].'</option>';
    	}

?>