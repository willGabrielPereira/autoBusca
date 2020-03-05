<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php 
	include 'simple_html_dom.php';
	include 'classes/automovel.class.php';
	include 'classes/listaCarros.class.php';
	 ?>
	 <link rel="stylesheet" type="text/css" href="../css/css.css">
	 <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
	 <style>
	 	body{
	 		background-image: url('img/results.jpg');
	 		background-attachment: fixed;
	 		background-repeat: no-repeat;
	 	}
	 </style>
</head>
<body>
<?php 
	if (isset($SESSION['loged'])&&$SESSION['loged']==TRUE) {
		include 'menu_loged.php';
	}else{
		include 'menu.php';
	}
	$carro = "";
 ?>
 <br>
	<div class="container">
		<div class="left">
			<div class="tipocontainer">

<?php
		$lista = new ListaCarros;
if (isset($_GET['botao'])) {
	//puxa os filtros
	$marca = $_GET['marca'];
	$car = $_GET['car'];
	echo '<h2>Veículo pesquisado: '.$marca.' '.$car."</h2>";
	$car = str_replace(" ", "-", $car);
	$year1 = $_GET['year1'];
	//echo $year1." - ano1<br>";
	$year2 = $_GET['year2'];
	//echo $year2." - ano2<br>";

	//puxa a biblioteca 
	

	//cria endereço url
	if (($_GET['year1'] > 0) && ($_GET['year2'] > 0)) {
		$urlML = 'http://carros.mercadolivre.com.br/carros-e-caminhonetes/'.$marca.'/'.$car.'/'.'santa-catarina/'.$year1.'-'.$year2.'/';
		$urlCC = 'https://www.curtocarro.com.br/busca-rapida/carro-camioneta/'.$marca.'/'.$car.'/'.$year1.'/'.$year2;
		$urlWM = 'https://www.webmotors.com.br/carros/sc/'.$marca.'/'.$car.'/de.'.$year1.'/ate.'.$year2;
	}elseif ($_GET['year1'] > 0) {
		$urlML = 'https://carros.mercadolivre.com.br/carros-e-caminhonetes/'.$marca.'/'.$car.'/'.$year1.'/';
		$urlML = str_replace("%3A", "", $urlML);
		$urlCC = 'https://www.curtocarro.com.br/busca-rapida/carro-camioneta/'.$marca.'/'.$car.'/'.$year1;
		$urlWM = 'https://www.webmotors.com.br/carros/sc/'.$marca.'/'.$car.'/de.'.$year1;
	}elseif ($_GET['year2'] > 0) {
		$urlML = 'https://carros.mercadolivre.com.br/carros-e-caminhonetes/'.$marca.'/'.$car.'/'.$year2.'/';
		$urlML = str_replace("%3A", "", $urlML);
		$urlCC = 'https://www.curtocarro.com.br/busca-rapida/carro-camioneta/'.$marca.'/'.$car.'/'.$year2;
		$urlWM = 'https://www.webmotors.com.br/carros/sc/'.$marca.'/'.$car.'/de.'.$year2;
	}elseif (($_GET['year1'] <= 0) && ($_GET['year2'] <= 0)) {
		$urlML = 'http://carros.mercadolivre.com.br/carros-e-caminhonetes/'.$marca.'/'.$car;
		$urlML = str_replace("%3A", "", $urlML);
		$urlCC = 'https://www.curtocarro.com.br/busca-rapida/carro-camioneta/'.$marca.'/'.$car;
		$urlWM = 'https://www.webmotors.com.br/carros/sc/'.$marca.'/'.$car;
	}

	set_time_limit(0);
	$html = new simple_html_dom();
	error_reporting(E_ALL & ~E_WARNING);
	
//   ******#### procura do mercado livre ####******		//
	$html->load_file($urlML);
	//echo $urlML."<br>";
	//acha os carros
	if (!(($error=error_get_last())!==null)) {
		$pagina = $html->find("div.rowItem");


		foreach ($pagina as $q) {

			$nome = $q->find(".main-title");
			$urlK = $q->find('a.item__info-link');
			$img = $q->find("div.item__image div.images-viewer div.carousel ul li a.item-link img.lazy-load");
			$preco = $q->find("div.item__info div.item__price span.price-fraction");
			$quilometro = $q->find("div.item__info div.item__attrs");

			$listaCarro = array();
			for ($o=0; $o < count($nome); $o++) {
				$nome = $nome[$o]->plaintext;
				$url = $urlK[$o]->href;
				if (!empty($img[$o])) {
					$foto = $img[$o]->src;
				}else{
					$foto = "img/padrao.jpg";
				}
				$preco = round(str_replace(".","", str_replace(" ", "", $preco[$o]->plaintext)), 2);
				$quilometro = $quilometro[$o]->plaintext;

				$cr = new Automovel($nome, $url, $foto, $preco, $quilometro);

				$lista->addCarro($cr);
				}
				$carro++;
		}
		
	}else{
		echo "<h4 class='erroVeiculo'>Veículo não encontrado no site <a href='".$urlML."'> mercadolivre.com.br</a></h4>";
	}
	$html->clear();
}

?>
<?php 
//	******#### procura do webmotors ####********	//
/*	$html->load_file($urlWM);
	$error = "";
	if (!(($error=error_get_last())!==null)) {
		$pagina = $html->find("a.tipo1 div.advert div.c-after");
		$urlK = $html->find('a.tipo1');
		$v = 0;
		$prop = "data-original";
		foreach ($pagina as $q) {

			//echo "<pre>";
			$nome = $q->find("h2");
			$img = $q->find("div.photo img.grd");
			$preco = $q->find("div.space-preco");
			$quilometro = $q->find("div.info-veiculo");

			for ($o=0; $o < count($nome); $o++) { 
				$nome = str_replace("    ", "", str_replace("      ","",$nome[$o]->plaintext));
				$url = $urlK[$v]->href;
				if (!empty($img[$o])) {
					$foto = $img[$o]->$prop;
				}else{
					$foto = "img/padrao.jpg";
				}
				if (!empty($preco[$o])) {
					$preco = $preco[$o]->plaintext;
					$preco = str_replace("R$", "", $preco);
					$preco = str_replace(" ", "", $preco);
					$preco = str_replace(".", "", $preco);
					$preco = round($preco, 2);
				}else{$preco = 0;}

				$quilometro = $quilometro[$o]->plaintext;
				$quilometro = str_replace("       ", "", $quilometro);
				$quilometro = str_replace("  ", "", $quilometro);
				$cr = new Automovel($nome, $url, $foto, $preco, $quilometro);
				$lista->addCarro($cr);
				$v++;
				}
				$carro++;
			}


	}else{
		echo "<h4 class='erroVeiculo'>Veículo não encontrado no site <a href='".$urlWM."'> webmotors.com.br</a></h4>";
	}
	$html->clear();
 ?>

<?php 
//	******#### procura do curto carros ####*******	//
	/*$html->load_file($urlCC);
	echo "<br>".$urlCC;

	if (!(($error=error_get_last())!==null)) {
		$pagina = $html->find("div.carro");
		echo $html;
		foreach ($pagina as $p) {
			echo $p;
		}

	}*/
 ?>

<?php 
if ($carro > 0) {
	echo '<h3>Foram encontrados '.$carro.' carros</h3><br>';
	for ($c=0; $c < $carro; $c++) { 
		$lista->mostraCarro($c);
	}	
}
?>
</div>
</div>
</div>
</body>
</html>