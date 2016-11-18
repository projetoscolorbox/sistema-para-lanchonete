
<?php

	$usuario_id = $_SESSION['usuario'];

	if($_SESSION['configuracao'] == "1"){
		//Caso seja cliente
		$abrirPedido = "<a href='index.php?acao=pedido-abrir'>Abrir novo pedido</a>";
		echo $abrirPedido;

		//Mostrando as informações de pedidos realizados desse cliente
		$conexao = new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());

		$stmtSelect = "SELECT U.usuario_nome,P.pedido_id,I.item_quantidade,Pro.produto_nome,Pro.produto_preco 
			FROM tb_pedidos as P
		    JOIN tb_usuarios as U ON U.usuario_id = P.usuario_id
		    JOIN tb_itens as I ON I.pedido_id = P.pedido_id
		    Join tb_produtos as Pro ON I.produto_id = Pro.produto_id
			WHERE P.pedido_apagado = '0' AND P.usuario_id ='$usuario_id' 
			ORDER BY pedido_data DESC;";

		$querySelect = $conexao->query($stmtSelect);
		$dados = $querySelect->fetchAll();
		if( isset($dados['0']['usuario_nome'])  ){
			$usuario_nome = $dados['0']['usuario_nome'];


			$tabela = "<table width='500' border='1'>
						<tr>
							<th width='250'>Usuario:</th>
							<td align='center'>$usuario_nome</td>
						</tr>
					   </table><br>";

			
			foreach ($dados as $pedidos) {

				$pedido_id = $pedidos['pedido_id'];
				$item_quantidade = $pedidos['item_quantidade'];
				$produto_nome = $pedidos['produto_nome'];	
				$tabela .=	"
						<table width='500' border='1'>
							<tr>
								<th width='250'>Pedido ID:</th>
								<td align='center'>$pedido_id</td>
							</tr>
						</table>
						<table width='500' border='1'>
							<tr>
								<th width='250'>Quantidade</th>
								<th>Produto</th>
							</tr>
							<tr>
								<td align='center'>$item_quantidade</td>
								<td align='center'>$produto_nome</td> 
							</tr>
						</table><br>";
				}	


			
			echo $tabela;
		}

		

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
				$tabela .= "<td><a href='index.php?acao=pedido-finalizar&pedID=".$pedido['pedido_id']."'>Finalizar</a></td>";
			}

			if($gerenciar == 1){
				$tabela .= "<td><a href='index.php?acao=pedido-gerenciar&pedID=".$pedido['pedido_id']."'>Alterar Andamento</a></td>";
			}
			$stmtSelect = "SELECT I.item_quantidade,I.produto_id,I.produto_preco,P.produto_nome as produto_nome FROM tb_itens as I join tb_produtos as P on P.produto_id = I.produto_id WHERE pedido_id = '".$pedido['pedido_id']."';";
			$querySelect = $conexao->query($stmtSelect);
			$itens = $querySelect->fetchAll();
			$balanco = 0;

			$tabela .= "<table width='500' border='1'>
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
			$tabela .= "<table width='500' border='1'>
							<tr>
								<th>Nome do produto</th>
								<th>Preco</th>
								<th>Quandidade</th>
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