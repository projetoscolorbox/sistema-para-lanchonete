<?php
	#error_reporting(0);
	session_start();
	require_once "banco_mysql.php";
	require_once "../config.php";

	if(isset($_POST) && !empty($_POST)){

		foreach ($_POST as $key => $value) {#envitando SQL injection
			$_POST[$key] = addslashes($_POST[$key]);
		}

		extract($_POST);
		

		#preparando o vetor com os dados de usuario
		$dadosUsuario = array(
			'usuario_login' => $user,
			'usuario_senha' => $password,
			'usuario_nome' => $nome,
			'usuario_telefone' => $telefone,
			'usuario_celular' => $celular,
			'usuario_email' => $email,
			'endereco_cep' => $cep,
			'usuario_data_cadastro' => $data_cadastro = date("Y-m-d H:i:s"),
			'usuario_complemento' => $complemento
		);

		$dadosEndereco = array(
			'endereco_cep'=>$cep,
			'endereco_logradouro'=>$logradouro,
			'endereco_bairro'=>$bairro,
			'endereco_localidade'=>$localidade
		);


		$conexao = new Banco($_SERVER['HTTP_HOST'],$config->getBaseDados(),$config->getLogin(),$config->getSenha());

		if( isset($dadosUsuario['usuario_login']) && !empty($dadosUsuario['usuario_login']) && isset($dadosUsuario['usuario_senha']) && !empty($dadosUsuario['usuario_senha']) ){


			$queryInsertEndereco = $conexao->insert('tb_enderecos',$dadosEndereco);
			$queryInsertUsuario = $conexao->insert('tb_usuarios',$dadosUsuario);
			


			#recuperar o id recem criado para esse usuario
			$banco = new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());
			$sql = $banco->query("SELECT * FROM tb_usuarios WHERE usuario_login='$user' AND usuario_senha='$password';");#' or 1='1
			
			if($sql->rowCount()>0 ){

				$dado = $sql->fetch();
				$_SESSION['usuario'] = $dado['usuario_id'];
				$_SESSION['configuracao'] = $configuracao = $dado['configuracao_id'];
				$_SESSION['nome'] = $nome = $dado['usuario_nome'];

				$stmt = $banco->query("SELECT * FROM tb_configuracoes WHERE configuracao_id='$configuracao';");
				$_SESSION['set'] = $stmt->fetch();

				header("Location: ../index.php");


			}


		}

		echo "Faltou preecher ou o login ou a senha.";
		
	}
	

?>
<form method='POST' >
	<label>Usuário:</label>
	<br>
	<input type='text' name='user'>

	<br><br>
	<label>Senha:</label>
	<br>
	<input type='password' name='password'>

	<br><br>
	<label>Nome:</label>
	<br>
	<input type='text' name='nome'>

	<br><br>
	<label>Telefone:</label>
	<br>
	<input type='text' name='telefone'>

	<br><br>
	<label>Celular:</label>
	<br>
	<input type='text' name='celular'>

	<br><br>
	<label>Email:</label>
	<br>
	<input type='text' name='email'>

	<br><br>
	<label>Cep:</label>
	<br>
	<input type='text' name='cep'>

	<br><br>
	<label>Logradouro:</label>
	<br>
	<input type='text' name='logradouro'>

	<br><br>
	<label>Bairro:</label>
	<br>
	<input type='text' name='bairro'>

	<br><br>
	<label>Localidade:</label>
	<br>
	<input type='text' name='localidade'>

	<br><br>
	<label>Complemento:</label>
	<br>
	<input type='text' name='complemento'>

	<br><br>
	<input type='submit' name='entrar' value='Cadastrar'>
</form>
