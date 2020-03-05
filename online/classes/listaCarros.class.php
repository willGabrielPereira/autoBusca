<?php 
include_once 'automovel.class.php';
class ListaCarros{
	private $carros;

	public function __construct($c = ""){
		if (!($c == 0)) {
			$this->carros[] = $c;
		}

	}

	public function addCarros($c){
		foreach ($c as $i) {
			$this->carros[] = $i;
		}
		$this->calculaPreco();
	}

	public function addCarro($c){
		$this->carros[] = $c;
		//$this->calculaPreco();
		//var_dump($this->carros);
		//echo "<h1>fechou var_dump(carro)</h1>";
	}

	public function countCarros(){
		return count($this->carros);
	}

	public function calculaPreco(){
		$this->verificaCarros();
		//array_unique($this->carros);
		$aux = "";
		//var_dump($this->carros);
		//	for com minimo em 0 e máximo com numero de objetos menos 1
		for ($i=0; $i < (count($this->carros) -1); $i++) { 
			//	for com minimo em i mais 1 e maximo com numero de objetos
			for ($j=$i+1; $j < count($this->carros); $j++) { 
				//	verifica qual o menor preco
				//var_dump($this->carros[$i]);
				if ($this->carros[$i]->mostraPreco() > $this->carros[$j]->mostraPreco()) {
					$aux = $this->carros[$i];
					$this->carros[$i] = $this->carros[$j];
					$this->carros[$j] = $aux;
				}
			}
		}
		//var_dump($this->carros);
	}

	public function verificaCarros(){
		//echo "<br>função destroi";
		//	for com minimo em 0 e máximo com numero de objetos menos 1
		for ($i=0; $i < (count($this->carros) -1); $i++) {
			//echo "<br>for detroi i: ".$i; 
			//	for com minimo em i mais 1 e maximo com numero de objetos
			for ($j=$i+1; $j < count($this->carros); $j++) {
				//echo "<br>for destroi j: ".$j."<br>"; 
				//	verifica qual o menor preco
				//var_dump($this->carros[$i]->mostraUrl());
				//echo spl_object_hash($this->carros[$i]);
				//var_dump($this->carros[$j]->mostraUrl());//die;
				if ($this->carros[$i]->mostraUrl() === $this->carros[$j]->mostraUrl()) {
					//echo "<br>carro[".$i."] é igual a carro[".$j."]";
					unset($this->carros[$j]);
				}
			}
		}
	}	

	public function mostraCarro($o){
		$this->calculaPreco();
		$q = "<div class='carro bloco'>\n";
		$q .= "<a href='".$this->carros[$o]->mostraUrl()."'>\n";
		$q .= "<div class='imagemCarro'>\n";
		$q .="<img src='".$this->carros[$o]->mostraFoto()."'></div>\n";

		$q .= "<div class='descricao'>\n";
		$q .= "<h2 class='nomeCarro'><p>".$this->carros[$o]->mostraNome()."</p></h2>\n";
		$preco = number_format($this->carros[$o]->mostraPreco(), 2, ",", " ");
		if ($o == 0) {
			$q .= "<div class='precoBaixo preco'><h3>R$: ".$preco."</h3></div>";
		}else{
			$q .= "<div class='preco'><h3>R$: ".$preco."</h3></div>";
		}
		$q .= "<div class='quilometro'><h3>".$this->carros[$o]->mostraQuilometro()."</h3></div>";
		$q .= "</div>";
		$q .= "</a></div>";
		echo $q;
	}
}

 ?>