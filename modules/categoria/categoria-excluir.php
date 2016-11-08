<?php 
	
	$conexao =  new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());


	$catID = addslashes($_GET['catID']);

		
	$stmtUpdate = "UPDATE tb_categorias SET categoria_apagado ='1' WHERE categoria_id='$catID';";
	
	$queryUpdate = $conexao->query($stmtUpdate);
	$total = $queryUpdate->rowCount();

	if($total > 0){
			
		header("Location: index.php?acao=Categoria");
			
	}

?>