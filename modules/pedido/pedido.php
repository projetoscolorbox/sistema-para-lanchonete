<div class='titulo'>Pedidos</div>
<?php
	
	echo "<meta HTTP-EQUIV='refresh' CONTENT='60;URL=index.php?acao=Pedido'>";

	$usuario_id = $_SESSION['usuario'];

	if($_SESSION['configuracao'] == "1"){
		//Caso seja cliente

		echo "<div class='funcao'><a href='?acao=pedido-abrir' class='funcao'>Abrir novo Pedido</a></div>";
		//Recuperando as informações de pedidos guardadas no banco e montando a tabela
		$conexao = new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());

		$stmtSelect = "SELECT pedido_id,pedido_andamento FROM tb_pedidos WHERE pedido_apagado='0' AND usuario_id ='$usuario_id' ORDER BY pedido_id DESC;";
		$querySelect = $conexao->query($stmtSelect);
		$pedidos = $querySelect->fetchAll();
		$total = $querySelect->rowCount();

		//Montando a tabela com os pedidos
		$tabela = "";
		foreach ($pedidos as $pedido) {

			$stmtSelect = "SELECT I.item_quantidade,I.produto_id,I.produto_preco,P.produto_nome as produto_nome FROM tb_itens as I join tb_produtos as P on P.produto_id = I.produto_id WHERE pedido_id = '".$pedido['pedido_id']."';";
			$querySelect = $conexao->query($stmtSelect);
			$itens = $querySelect->fetchAll();
			$balanco = 0;

			$tabela .= "<table class='table-conteiner'>
						<tr>
							<th>Pedido ID:</th>
							<th>".$pedido['pedido_id']."</th>
						</tr>
						<tr>
							<th>Andamento</th>
							<th>".$pedido['pedido_andamento']."</th>
						</tr>
					</table>";

			//listando os itens do pedido
			$tabela .= "<table class='table-conteiner'>
							<tr>
								<th>Nome do produto</th>
								<th>Preco</th>
								<th>Quantidade</th>
							</tr>";

			foreach ($itens as $item) {				

				$tabela .= "<tr>
								<td>".$item['produto_nome']."</td>
								<td>".$item['produto_preco']."</td>
								<td>".$item['item_quantidade']."</td>";

				$balanco += $item['produto_preco']*$item['item_quantidade'] ;

			}
						
			$tabela .= "		
							</tr>
							<tr>
								<th colspan='2'>Total</th>
								<td>R$".$balanco."</td>
							</tr>
						</table><br>";
		}
		
		echo $tabela;

		

	}else{
		//Caso n seja cliente

		//Recuperando as informações de pedidos guardadas no banco e montando a tabela
		$conexao = new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());

		$stmtSelect = "SELECT pedido_id,pedido_andamento FROM tb_pedidos WHERE pedido_apagado='0' AND pedido_andamento != 'Finalizado' ORDER BY pedido_id DESC;";
		$querySelect = $conexao->query($stmtSelect);
		$pedidos = $querySelect->fetchAll();
		$total = $querySelect->rowCount();


		#carregando as configurações da pagina de pedido do funcionario##########
		$gerenciar = $_SESSION['set']['pedido_gerenciar'];
		$finalizar = $_SESSION['set']['pedido_finalizar'];

		//Montando a tabela com os pedidos
		$tabela = "";
		foreach ($pedidos as $pedido) {


			//Carregando as funcionalidades
			if($finalizar == 1){
				$tabela .= "<div class='funcao'><a href='index.php?acao=pedido-finalizar&pedID=".$pedido['pedido_id']."' >Finalizar</a></div>";
			}

			if($gerenciar == 1){
				$tabela .= "<div class='funcao'><a href='index.php?acao=pedido-gerenciar&pedID=".$pedido['pedido_id']."' >Alterar Andamento</a></div>";
			}
			$stmtSelect = "SELECT I.item_quantidade,I.produto_id,I.produto_preco,P.produto_nome as produto_nome FROM tb_itens as I join tb_produtos as P on P.produto_id = I.produto_id WHERE pedido_id = '".$pedido['pedido_id']."';";
			$querySelect = $conexao->query($stmtSelect);
			$itens = $querySelect->fetchAll();
			$balanco = 0;

			$tabela .= "<table class='table-conteiner'>
						<tr>
							<th>Pedido ID:</th>
							<th>".$pedido['pedido_id']."</th>
						</tr>
						<tr>
							<th>Andamento</th>
							<th>".$pedido['pedido_andamento']."</th>
						</tr>
					</table>";

			//listando os itens do pedido
			$tabela .= "<table class='table-conteiner'>
							<tr>
								<th>Nome do produto</th>
								<th>Preco</th>
								<th>Quantidade</th>
							</tr>";

			foreach ($itens as $item) {				

				$tabela .= "<tr>
								<td>".$item['produto_nome']."</td>
								<td>".$item['produto_preco']."</td>
								<td>".$item['item_quantidade']."</td>";

				$balanco += $item['produto_preco']*$item['item_quantidade'] ;

			}
						
			$tabela .= "		
							</tr>
							<tr>
								<th colspan='2'>Total</th>
								<td>R$".$balanco."</td>
							</tr>
						</table>";
		}
		
		echo $tabela;

	}
?>