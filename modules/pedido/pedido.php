
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

		if($_SESSION['set']['pedido_gerenciar']=="1"){
			echo "<a href='acao=pedido-gerenciar&pedID=$pedido_id'>Gerenciar</a>";
		}
		if($_SESSION['set']['pedido_finalizar']=="1"){
			echo "<a href=''>Finalizar</a>";
		}
		#carregando as configurações da pagina de pedido do funcionario##########
		$gerenciar = $_SESSION['set']['pedido_gerenciar'];
		$finalizar = $_SESSION['set']['pedido_finalizar'];

		$tabela = "<table width='800' border='1'>
					<tr>
						<th>ID do Pedido</th>
						<th>Nome do Cliente</th>
						<th>Endereco</th>
						<th>Andamento do Pedido</th>
						<th>Ação</th>
					<tr>
					</table>";

		echo $tabela;

	}
?>