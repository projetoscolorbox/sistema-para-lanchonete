<form method='GET'>
<?php
	
	if( isset($_GET['andamento']) && !empty($_GET['andamento']) ){
		$conexao =  new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());


		$pedID = addslashes($_GET['pedID']);
		$pedido_andamento = addslashes($_GET['andamento']);


			
		$stmtUpdate = "UPDATE tb_pedidos SET pedido_andamento ='$pedido_andamento' WHERE pedido_id='$pedID';";
		print_r($stmtUpdate);
		$queryUpdate = $conexao->query($stmtUpdate);
		$total = $queryUpdate->rowCount();

		if($total > 0){
				
			header("Location: index.php?acao=Pedido");
				
		}

	}else{

		$pedido_id = addslashes($_GET['pedID']);

		$form = "Andamento do pedido ID: ".$pedido_id."<br>";

		#recuperando a situação do pedido
		$conexao =  new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());

		$stmtSelect = "SELECT pedido_andamento FROM tb_pedidos WHERE pedido_id = '$pedido_id';";
		$querySelect = $conexao->query($stmtSelect);
		$situacao = $querySelect->fetch();
		$situacao = $situacao['pedido_andamento'];

		#montando o Combo Box
		$CB_andamento = "<select name='andamento'>
							<option>".$situacao."</option>";
		switch ($situacao) {
			case 'Aguardando Recepção':
				$CB_andamento .= "<option>Em Preparo</option>
								<option>Despachado</option>";
				break;
				
			case 'Em Preparo':
				$CB_andamento .= "<option>Aguardando Recepção</option>
								<option>Despachado</option>";
				break;

			case 'Despachado':
				$CB_andamento .= "<option>Aguardando Recepção</option>
								<option>Em Preparo</option>";
				break;
		}

		$CB_andamento .= "</select>";

		echo $CB_andamento;

		echo "<input type='hidden' name='pedID' value='".$_GET['pedID']."'>";

	}
		
?>
<input type='hidden' name='acao' value='pedido-gerenciar'>
<input type='submit' name='' value='Enviar'>
</form>