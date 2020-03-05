<?php 
class Automovel{
	//		variaveis
	private $nome;
	private $url;
	private $foto;
	private $preco;
	private $quilometro;

	//		construtor
	public function __construct($n, $u, $f, $p, $km = ""){
		$this->nome = $n;
		$this->url = $u;
		$this->foto = $f;
		$this->preco = $p;
		$this->quilometro = $km;
	}

	public function addNumero($n){
		$this->numero = $n;
	}

	//		mostra cada um
	public function mostraNome(){
		return $this->nome;
	}
	public function mostraUrl(){
		return $this->url;
	}
	public function mostraFoto(){
		return $this->foto;
	}
	public function mostraPreco(){
		return $this->preco;
	}
	public function mostraQuilometro(){
		return $this->quilometro;
	}

	//		mostra tudo
	public function mostraTudo(){
		$d[] = $this->nome;
		$d[] = $this->url;
		$d[] = $this->foto;
		$d[] = $this->preco;
		$d[] = $this->quilometro;

		return $d;
	}


}
?>