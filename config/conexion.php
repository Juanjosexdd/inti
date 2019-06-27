<?php

	session_start();

	class Conectar {

	 	public $dbh;

	 	protected function conexion(){
	 		try {
	 			$conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=inti","root","");
			    return $conectar;
	 		} catch (Exception $e) {
	 			print "¡Error!: " . $e->getMessage() . "<br/>";
	            die();  
	 		}
		} //cierre de llave de la function conexion()

		public function conexion_public(){
			try {
				$conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=inti","root","");
			   return $conectar;
			} catch (Exception $e) {
				print "¡Error!: " . $e->getMessage() . "<br/>";
			   die();  
			}
	   } //cierre de llave de la function conexion()

		public function set_names(){
			return $this->dbh->query("SET NAMES 'utf8'");
		}

		public function ruta(){
			return "http://localhost/inti/";
		}
	}//cierre de llave conectar 		
		  	
?>