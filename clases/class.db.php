<?php

class Db{
	private $dbhost = 'localhost';
	private $dbuser = 'root';
	private $dbpass = '';
	private $dbname = 'rosquilla';
	private $conexion;
	private $reultado;
	private $consulta;

	public function __construct (){
		
		$this->conexion= new  mysqli($this->dbhost,$this->dbuser,$this->dbpass,$this->dbname);
	}
	public function consulta($consulta){
		
		$this->resultado = $this->conexion->query($consulta);
		return $this->resultado;
	}
	public function listar($muestra){
		$muestra = $this->conexion->mysqli_fetch_array($muestra);
		return $res;
	}
}

?>