<?php 
	
		
	$conexao =  new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());


	$prodID = addslashes($_GET['prodID']);

		
	$stmtUpdate = "UPDATE tb_produtos SET produto_apagado ='1' WHERE produto_id='$prodID';";
	
	$queryUpdate = $conexao->query($stmtUpdate);
	$total = $queryUpdate->rowCount();

	if($total > 0){
			
		header("Location: index.php?acao=Produto");
			
	}

?>