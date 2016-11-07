<?php
	error_reporting(1);
	if(isset($_GET['catNome']) && !empty($_GET['catNome'])){

		$conexao =  new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());

		$categoria_nome = addslashes($_GET['catNome']);
		$stmtInsert = "INSERT INTO tb_categorias SET categoria_nome ='$categoria_nome', categoria_apagado = '0';";
		
		$queryInsert = $conexao->query($stmtInsert);
		$total = $queryInsert->rowCount();
		
		if($total > 0){
			
			header("Location: index.php?acao=Categoria");
			
		}

	}
	
?>

<form method='GET' >
	Nome:
	<input type='text' name='catNome'>
	<br>
	<input type='submit' name='' value='Cadastrar'>
	<input type='hidden' name='acao' value='categoria-cadastrar'>
</form>