<?php 
	
		
	$conexao =  new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());
	
	if (isset($_GET['userID']) && !empty($_GET['userID'])) {

		$userID = addslashes($_GET['userID']);


		#recuperando os dados do usuario para edição
		$stmtSelect = "SELECT * FROM tb_usuarios WHERE usuario_id='$userID';";
		$querySelect = $conexao->query($stmtSelect);
		$usuario = $querySelect->fetch();

		$usuario_id = $usuario['usuario_id'];
		$usuario_login = $usuario['usuario_login'];
		$usuario_senha = $usuario['usuario_senha'];
		$usuario_nome = $usuario['usuario_nome'];
		$usuario_telefone = $usuario['usuario_telefone'];
		$usuario_celular = $usuario['usuario_celular'];
		$usuario_email = $usuario['usuario_email'];
		$endereco_cep = $usuario['endereco_cep'];
		$usuario_complemento = $usuario['usuario_complemento'];
		$configuracao_id = $usuario['configuracao_id'];

		$stmtSelect = "SELECT * FROM tb_enderecos WHERE endereco_cep='$endereco_cep';";

		$querySelect = $conexao->query($stmtSelect);
		$endereco = $querySelect->fetch();

		$endereco_logradouro = $endereco['endereco_logradouro'];
		$endereco_bairro = $endereco['endereco_bairro'];
		$endereco_localidade = $endereco['endereco_localidade'];


		##########Montando o combo box####################
		#recuperando os dados
		$conexao =  new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());

		$stmtSelect = "SELECT configuracao_id,configuracao_nome FROM tb_configuracoes WHERE configuracao_apagado = '0';";
		
		$querySelect = $conexao->query($stmtSelect);
		$dadosCB = $querySelect->fetchAll();

		#montando o Combo Box

		foreach ($dadosCB as $item) {#para descobrir o nome da $configuracao_id
			if($configuracao_id == $item['configuracao_id']){
				$configuracao_nome = $item['configuracao_nome'];
			}
		}


		$CB_configuracoes = "<select name='configuracao_id'>
							<option value='$configuracao_id'>$configuracao_nome</option>";

		foreach ($dadosCB as $item) {
			
			$id = $item['configuracao_id'];
			$configuracao_nome = $item['configuracao_nome'];

			if($configuracao_id != $id){
				$CB_configuracoes .= "<option value='$id'>$configuracao_nome</option>";
			}

		}
		$CB_configuracoes .= "</select>";




		#teminando de montar o formulario#################################################

		$formulario = 
		"<div class='titulo'>Editar Usuario</div>
		<div class='formulario'>
		<form method='POST' >
			<label>Usuário:</label>
			<br>
			<input type='text' name='usuario_login' value='$usuario_login'>

			<br><br>
			<label>Senha:</label>
			<br>
			<input type='password' name='usuario_senha' value='$usuario_senha'>

			<br><br>
			<label>Nome:</label>
			<br>
			<input type='text' name='usuario_nome' value='$usuario_nome'>

			<br><br>
			<label>Telefone:</label>
			<br>
			<input type='text' name='usuario_telefone' value='$usuario_telefone'>

			<br><br>
			<label>Celular:</label>
			<br>
			<input type='text' name='usuario_celular' value='$usuario_celular'>

			<br><br>
			<label>Email:</label>
			<br>
			<input type='text' name='usuario_email' value='$usuario_email'>

			<br><br>
			<label>Cep:</label>
			<br>
			<input type='text' name='endereco_cep' value='$endereco_cep'>

			<br><br>
			<label>Logradouro:</label>
			<br>
			<input type='text' name='endereco_logradouro' value='$endereco_logradouro'>

			<br><br>
			<label>Bairro:</label>
			<br>
			<input type='text' name='endereco_bairro' value='$endereco_bairro'>

			<br><br>
			<label>Localidade:</label>
			<br>
			<input type='text' name='endereco_localidade' value='$endereco_localidade'>

			<br><br>
			<label>Complemento:</label>
			<br>
			<input type='text' name='usuario_complemento' value='$usuario_complemento'>

			<br><br>
			<label>Configuracao:</label>
			<br>
			$CB_configuracoes
			<br><br>
			<input type='submit' name='' value='Editar'>
			<input type='hidden' name='acao' value='usuario-editar'>
		</form>
		</div>";

		echo $formulario;

		if( !empty($_POST) ){


			foreach ($_POST as $key => $value) {#envitando SQL injection
				
				$_POST[$key] = addslashes($_POST[$key]);
				
				if( !empty($_POST[$key]) ){

					$dadosUpdate[$key] = $_POST[$key];

				}

			}
			array_pop($dadosUpdate);

			#procurando os dados relacionandos ao endereço
			$n = 0;
			foreach ($dadosUpdate as $key => $value) {

				if( ($key == "endereco_logradouro") OR ($key == "endereco_bairro") OR ($key == "endereco_localidade")){
					$aux = array_slice($dadosUpdate, $n, 1, true);
					$endereco[$key] = $aux[$key];
				}

				$n++;

			}


			if( isset($endereco) && !empty($endereco) ){
				$dadosUpdate = array_diff_assoc($dadosUpdate, $endereco);
			}

			$conexao = new Banco($_SERVER['HTTP_HOST'],$config->getBaseDados(),$config->getLogin(),$config->getSenha());
				
			if( isset($endereco) && !empty($endereco) ){
				$conexao->update("tb_enderecos",$endereco);
			}

			$conexao->update("tb_usuarios",$dadosUpdate,$arrayName = array('usuario_id' => $usuario_id));


			#print_r($dadosUpdate);
			#print_r($endereco);
			header("Location: index.php?acao=Usuario");

		}	




	}

?>