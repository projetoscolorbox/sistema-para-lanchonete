<?php
	session_start();
	require_once "../config.php";
	extract($_POST);

	if ( $_SESSION['usuario']==null ){#recupera o usuario e suas configurações

		try{

			$banco = new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());
			$sql = $banco->query("SELECT * FROM tb_usuarios WHERE usuario_login='$user' AND usuario_senha='$password';");

			if($sql->rowCount()>0 ){

				$dado = $sql->fetch();
				$_SESSION['usuario'] = $dado['usuario_id'];
				$_SESSION['configuracao'] = $configuracao = $dado['configuracao_id'];

				$stmt = $banco->query("SELECT * FROM tb_configuracoes WHERE configuracao_id='$configuracao';");
				$_SESSION['set'] = $stmt->fetch();

				

			}

		}catch(PDOException $e){

			echo "Falhou".$e->getMessage();
			
		}
	}

	header("Location: ../index.php");
?>