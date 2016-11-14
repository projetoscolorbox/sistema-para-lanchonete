<?php 
	
	
	$conexao =  new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());

	$userID = addslashes($_GET['userID']);
		
	$stmtUpdate = "UPDATE tb_usuarios SET usuario_apagado ='1' WHERE usuario_id='$userID';";
	
	$queryUpdate = $conexao->query($stmtUpdate);
	$total = $queryUpdate->rowCount();
	
	if($total > 0){
			
		header("Location: index.php?acao=Usuario");
			
	}


	

?>