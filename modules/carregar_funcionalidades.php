<?php
	session_start();
	require_once "../config.php";
	
	extract($_POST);
	if (!isset($_SESSION) ||  empty($_SESSION['usuario']) ){

		//recupera o usuario e suas configurações

		try{
			$banco = new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());
			$user = addslashes($user);
			$password = addslashes($password);
			$sql = $banco->query("SELECT * FROM tb_usuarios WHERE usuario_login='$user' AND usuario_senha='$password';");#' or 1='1
			
			if($sql->rowCount()>0 ){

				$dado = $sql->fetch();
				$_SESSION['usuario'] = $dado['usuario_id'];
				$_SESSION['configuracao'] = $configuracao = $dado['configuracao_id'];
				$_SESSION['nome'] = $nome = $dado['usuario_nome'];

				$stmt = $banco->query("SELECT * FROM tb_configuracoes WHERE configuracao_id='$configuracao';");
				$_SESSION['set'] = $stmt->fetch();

				

			}

		}catch(PDOException $e){

			echo "Falhou".$e->getMessage();
			
		}
	}

	header("Location: ../index.php");
?>