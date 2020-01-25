<?php
	Class Conexao{
		private function __construct(){
			
		}
		
		public static function getConexao(){
			try{
				$host = "localhost";
				$usuario = "root";
				$senha = "";
				$bd = "hgvjon";
				
				$conexao = new PDO("mysql:host=$host;dbname=$bd",$usuario,$senha);				
				$conexao->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				
			}catch(Exception $e){
                            print $e->getMessage();
                            exit();
			}
			return $conexao;
		}
		
		private function __clone(){
			
		}
		
		public function __destruct(){
			
		}
	}
	
?>