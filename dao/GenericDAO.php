<?php
	if(file_exists('util/Conexao.class.php')){
		require_once 'util/Conexao.class.php';
	}else{
		require_once '../util/Conexao.class.php';
	}
	
	class GenericDAO{
		public function __construct(){
			$this->conexao = Conexao::getConexao();
		}
		
		public function __destruct(){
			$this->conexao = NULL;
		}
	}

?>