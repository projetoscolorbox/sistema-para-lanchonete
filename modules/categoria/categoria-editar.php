<?php 
	error_reporting(1);
		
	$conexao =  new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());

	if (isset($_GET['catID'])) {

		$catID = addslashes($_GET['catID']);

		$stmtSelect = "SELECT * FROM tb_categorias WHERE categoria_id='$catID';";
		$querySelect = $conexao->query($stmtSelect);
		$categoria = $querySelect->fetch();
		$nome = $categoria['categoria_nome'];


		$formulario = 
		"<form method='GET'>
			<input type='hidden' name='catID' value='$catID'>
			Nome:
			<br>
			<input type='text' name='catNome' value='$nome'>
			<br>
			<input type='submit' name='' value='Editar'>
			<input type='hidden' name='acao' value='categoria-editar'>
		</form>";

		echo $formulario;

		if (isset($_GET['catNome'])) {
			
			$catNome = addslashes($_GET['catNome']);

			$stmtUpdate = "UPDATE tb_categorias SET categoria_nome ='$catNome' WHERE categoria_id='$catID';";
			echo $stmtUpdate;
			$queryUpdate = $conexao->query($stmtUpdate);
			$total = $queryUpdate->rowCount();

			if ($total > 0) {

				header("Location: index.php?acao=Categoria");

			}

		}



	}

?>
