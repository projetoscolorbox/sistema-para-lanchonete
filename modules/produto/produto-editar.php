<?php 
	require "../banco_mysql.php";
	require "../../config.php";
		
	$conexao =  new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());

	
	if (isset($_GET['prodID']) && !empty($_GET['prodID'])) {

		$prodID = addslashes($_GET['prodID']);

		$stmtSelect = "SELECT * FROM tb_produtos WHERE produto_id='$prodID';";
		$querySelect = $conexao->query($stmtSelect);
		$produto = $querySelect->fetch();
		$nome = $produto['produto_nome'];
		$preco = $produto['produto_preco'];

		print_r($_GET);

		$formulario = 
		"<form method='GET'>
			<input type='hidden' name='prodID' value='$prodID'>
			Nome:
			<input type='text' name='prodNome' value='$nome'>
			<br>
			Preco:
			<input type='text' name='prodPreco' value='$preco'>
			<br>
			<input type='submit'>
		</form>";

		echo $formulario;

		if(isset($_GET['prodNome']) && !empty($_GET['prodNome']) ){

			$prodNome = addslashes($_GET['prodNome']);
			$stmtUpdate = "UPDATE tb_produtos SET produto_nome ='$prodNome'";

			if( isset($_GET['prodPreco']) && !empty($_GET['prodPreco'])){

				$prodPreco = addslashes($_GET['prodPreco']);
				$stmtUpdate .= " ,produto_preco ='$prodPreco'"; 



			}

			$stmtUpdate .= " WHERE produto_id='$prodID';";
			echo $stmtUpdate;
			$queryUpdate = $conexao->query($stmtUpdate);

			header("Location: produto.php");

		}		
		



	}

?>