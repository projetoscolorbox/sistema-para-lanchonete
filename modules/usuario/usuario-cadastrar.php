<?php 
	
		
	$conexao =  new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());

	##########Montando o combo box####################
	#recuperando os dados
	$conexao =  new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());

	$stmtSelect = "SELECT configuracao_id,configuracao_nome FROM tb_configuracoes WHERE configuracao_apagado = '0' ORDER BY configuracao_nome;";
	
	$querySelect = $conexao->query($stmtSelect);
	$dadosCB = $querySelect->fetchAll();


	$CB_configuracoes = "<select name='configuracao_id'>";
							
	foreach ($dadosCB as $item) {
			
		$id = $item['configuracao_id'];
		$configuracao_nome = $item['configuracao_nome'];
		$CB_configuracoes .= "<option value='$id'>$configuracao_nome</option>";
		

	}
	$CB_configuracoes .= "</select>";




	#teminando de montar o formulario#################################################

	$formulario = 
		"<form method='POST' >
			<label>Usuário:</label>
			<br>
			<input type='text' name='usuario_login' >

			<br><br>
			<label>Senha:</label>
			<br>
			<input type='password' name='usuario_senha' >

			<br><br>
			<label>Nome:</label>
			<br>
			<input type='text' name='usuario_nome' >

			<br><br>
			<label>Telefone:</label>
			<br>
			<input type='text' name='usuario_telefone'>

			<br><br>
			<label>Celular:</label>
			<br>
			<input type='text' name='usuario_celular' >

			<br><br>
			<label>Email:</label>
			<br>
			<input type='text' name='usuario_email' >

			<br><br>
			<label>Cep:</label>
			<br>
			<input type='text' name='endereco_cep' >

			<br><br>
			<label>Logradouro:</label>
			<br>
			<input type='text' name='endereco_logradouro' >

			<br><br>
			<label>Bairro:</label>
			<br>
			<input type='text' name='endereco_bairro' >

			<br><br>
			<label>Localidade:</label>
			<br>
			<input type='text' name='endereco_localidade' >

			<br><br>
			<label>Complemento:</label>
			<br>
			<input type='text' name='usuario_complemento' >

			<br><br>
			<label>Configuracao:</label>
			<br>
			$CB_configuracoes
			<br><br>
			<input type='submit' name='' value='Editar'>
			<input type='hidden' name='acao' value='usuario-editar'>
		</form>";

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
				$endereco['endereco_cep'] = $dadosUpdate['endereco_cep'];
				$endereco['endereco_apagado'] = '0';
				$conexao->insert("tb_enderecos",$endereco);
			}

			$dadosUpdate['usuario_apagado'] = '0';
			$conexao->insert("tb_usuarios",$dadosUpdate);


			#print_r($dadosUpdate);
			#print_r($endereco);
			header("Location: index.php?acao=Usuario");

		}	




	

?>