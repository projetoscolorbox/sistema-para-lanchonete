<?php
	$conexao =  new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());


	$pedID = addslashes($_GET['pedID']);

		
	$stmtUpdate = "UPDATE tb_pedidos SET pedido_andamento ='Finalizado' WHERE pedido_id='$pedID';";
	
	$queryUpdate = $conexao->query($stmtUpdate);
	$total = $queryUpdate->rowCount();

	if($total > 0){
			
		header("Location: index.php?acao=Pedido");
			
	}
?>