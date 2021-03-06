<?php

	class Banco{

		private $pdo;
		private $numRows;
		private $array;

		public function __construct($host, $dbname, $dbuser, $dbpass){

			try{

				$this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host.";charset=utf8",$dbuser,$dbpass);

			}catch(PDOException $e){

				echo "Falhou : ".$e->getMessage();

			}

		}

		public function query($sql) {

			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();
			$this->numRows = $stmt->rowCount();
			$this->array = $stmt->fetchAll();

		}

		public function numRows(){

			return $this->numRows;

		}

		public function result() {

			return $this->array;

		}

		public function insert($table, $data = array()){

			if(!empty($table) && ((is_array($data)) && (count($data) > 0))){

				$sql = "INSERT INTO ".$table." SET ";

				$dados = array();

				foreach ($data as $chave => $valor) {
					if($valor!=NULL)
					$dados[] = $chave." = '".addslashes($valor)."'";
				
				}

				$sql = $sql.implode(", ",$dados).";";

				//echo $sql;
				$this->query($sql);
				return $this->pdo->lastInsertId();

			}
		}

		public function insertValues($table, $data = array(), $time = NULL){

			if(!empty($table) && ((is_array($data)) && (count($data) > 0))){
			
				$sql = "INSERT INTO ".$table." (";	

				if(is_array($time))
					$sql .= $time[0].",";

				$dados = array();
				$linhas = 0;
				foreach ($data as $chave => $valor) {
					$dados[] = $chave;
					$linhas = count($valor);
				}

				if($linhas>0){
					$sql .= implode(", ",$dados).") VALUES ('";

					if(is_array($time)){
						$sql .= $time[1]."','";	
					}


					$registros = array();
					foreach ($data[$chave] as $chave2 => $valor) {

						$valores = array();
						
						foreach ($data as $chave => $dados) {
							$valores[] = $dados[$chave2];
						}

						$registros[] = implode("','",$valores);
					}

					if(is_array($time)){
						$sql .= implode("'),('".$time[1]."','",$registros);	
					}
					else{
						$sql .= implode("'),('",$registros);
					}
					$sql .= "');";

					echo $sql;
					$this->query($sql);
				}
				

			}
		}

		public function update($table, $data = array(), $where = array(), $where_cond = "AND"){

			if(!empty($table) && (is_array($data) && count($data) > 0) && is_array($where)){

				$sql = "UPDATE ".$table." SET ";

				$dados = array();
				foreach ($data as $chave => $valor) {

					$dados[] = $chave." = '".addslashes($valor)."'";
				
				}

				$sql = $sql.implode(", ",$dados);

				if(count($where)>0){

					$dados = array();
					foreach ($where as $chave => $valor) {

						$dados[] = $chave." = '".addslashes($valor)."'";
					
					}


					$sql = $sql." WHERE ".implode(" ".$where_cond." ",$dados).";";

				}

				echo $sql;
				$this->query($sql);
				
			}


		}

		public function delete($table, $where = array(), $where_cond = "AND"){

			if(!empty($table) &&  is_array($where)){

				$sql = "DELETE FROM ".$table;

				if(count($where) > 0){

					$dados = array();

					foreach ($where as $chave => $valor) {

						$dados[] = $chave." = '".addslashes($valor)."'";
					
					}

					$sql = $sql." WHERE ".implode(" ".$where_cond." ",$dados).";";

				}

				echo $sql;
				$this->query($sql);

			}

		}



	}

?>