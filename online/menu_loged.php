<script src='jquery/jquery-3.2.1.min.js'></script>
<script>
  $(document).ready(function(){
    $(".btn-menu").click(function(){
      $(".menu").toggle();
      //$('.btn-menu').toogleClass(' gira');
    });
  });
</script>
<div class="row">
            <div class="col-2 img_menu div_img_menu">
              <a href="login.php"><img src="img/logo.png" class="logo_home"></a><br>
            </div>
    <div class="col-12">
       <div class="menu">
          <nav class="row-menu">
            <div class="col-2 text_menu">
              <a href="../cad_veiculo.php">Cadastrar veículo</a>
            </div>
            <div class="col-2 text_menu">
    	         <a href="../sobre.php">Quem somos</a><br>
            </div>
            <div class="col-2 text_menu">
    	        <a href="../online/index.php">Pesquisar</a><br>
             </div>
             <div class="col-2 img_menu">
               <a href="loged.php"><img src="img/usuarioteste.jpg" class="usuariofoto"></a>
            </div>
            <div class="col-2 img_menu">
    	         <a href="../loged.php?sair=TRUE"><i class="fa fa-sign-out fa-6x" aria-hidden="true"></i></a>
            </div>
          </nav>
        </div>
      </div>
    </div>
          <div class='btn-menu'>
            <i class='fa fa-bars fa-6x'></i>
          </div>
<br>