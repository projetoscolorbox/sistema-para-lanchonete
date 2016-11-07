<?php
	
	require "../../config.php";
	
	
	if(isset($_GET['prodNome']) && !empty($_GET['prodNome'])){

		$conexao =  new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());

		$produto_nome = addslashes($_GET['prodNome']);
		$stmtInsert = "INSERT INTO tb_produtos SET produto_nome ='$produto_nome',";

		if(isset($_GET['prodPreco']) && !empty($_GET['prodPreco'])){

			$produto_preco = addslashes($_GET['prodPreco']);
			$stmtInsert .= "produto_preco ='$produto_preco',";

		}

		$stmtInsert .= " produto_apagado = '0';";

		$conexao->query($stmtInsert);

		header("Location: produto.php");

	}

	
?>

<form method='GET'>
	Nome:
	<input type='text' name='prodNome'>
	<br>
	Preço:
	<input type='text' name='prodPreco'>
	<br>
	<input type='submit' name='' value='Cadastrar'>
</form>